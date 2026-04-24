<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\PemberianObat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PemberianObatController extends Controller
{
    public function index(Request $request): View
    {
        $query = PemberianObat::query()
            ->with(['pasien:id,nama,jenis_kelamin,umur', 'obat:id,nama_obat,bentuk_sediaan,kekuatan_dosis']);

        if ($request->filled('filter_pasien')) {
            $query->where('pasien_id', $request->integer('filter_pasien'));
        }

        if ($request->filled('filter_obat')) {
            $query->where('obat_id', $request->integer('filter_obat'));
        }

        if ($request->filled('filter_tanggal')) {
            $query->whereDate('tanggal_pemberian', $request->filter_tanggal);
        }

        $pemberianObats = $query
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $pasiens = Pasien::orderBy('nama')->get(['id', 'nama']);
        $obats = Obat::orderBy('nama_obat')->get(['id', 'nama_obat', 'bentuk_sediaan', 'kekuatan_dosis']);

        return view('pemberian_obats.index', compact('pemberianObats', 'pasiens', 'obats'));
    }

    public function create(): View
    {
        $pasiens = Pasien::orderBy('nama')->get(['id', 'nama', 'umur', 'jenis_kelamin']);
        $obats = Obat::with('informasiObat')
            ->orderBy('nama_obat')
            ->get();

        return view('pemberian_obats.create', compact('pasiens', 'obats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $obat = Obat::findOrFail($validated['obat_id']);

        if ($obat->stok < $validated['jumlah']) {
            return back()
                ->withInput()
                ->with('error', 'Stok obat tidak mencukupi. Stok tersedia: ' . $obat->stok);
        }

        $pemberian = PemberianObat::create($validated);

        $obat->decrement('stok', $validated['jumlah']);

        return redirect()
            ->route('pemberian_obats.show', $pemberian)
            ->with('success', 'Data pemberian obat berhasil ditambahkan!');
    }

    public function show(int $id): View
    {
        $pemberianObat = PemberianObat::with([
            'pasien',
            'obat.informasiObat',
        ])->findOrFail($id);

        return view('pemberian_obats.show', compact('pemberianObat'));
    }

    public function edit(int $id): View
    {
        $pemberianObat = PemberianObat::with(['pasien', 'obat'])->findOrFail($id);
        $pasiens = Pasien::orderBy('nama')->get(['id', 'nama', 'umur', 'jenis_kelamin']);
        $obats = Obat::orderBy('nama_obat')->get();

        return view('pemberian_obats.edit', compact('pemberianObat', 'pasiens', 'obats'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pemberianObat = PemberianObat::findOrFail($id);
        $validated = $this->validateData($request);

        $oldObat = Obat::findOrFail($pemberianObat->obat_id);
        $newObat = Obat::findOrFail($validated['obat_id']);

        if ($pemberianObat->obat_id === (int) $validated['obat_id']) {
            $availableStock = $newObat->stok + $pemberianObat->jumlah;

            if ($availableStock < $validated['jumlah']) {
                return back()
                    ->withInput()
                    ->with('error', 'Stok obat tidak mencukupi. Stok tersedia: ' . $availableStock);
            }

            $newObat->update([
                'stok' => $availableStock - $validated['jumlah'],
            ]);
        } else {
            if ($newObat->stok < $validated['jumlah']) {
                return back()
                    ->withInput()
                    ->with('error', 'Stok obat tidak mencukupi. Stok tersedia: ' . $newObat->stok);
            }

            $oldObat->increment('stok', $pemberianObat->jumlah);
            $newObat->decrement('stok', $validated['jumlah']);
        }

        $pemberianObat->update($validated);

        return redirect()
            ->route('pemberian_obats.show', $pemberianObat)
            ->with('success', 'Data pemberian obat berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $pemberianObat = PemberianObat::findOrFail($id);
        $obat = Obat::find($pemberianObat->obat_id);

        if ($obat) {
            $obat->increment('stok', $pemberianObat->jumlah);
        }

        $pemberianObat->delete();

        return redirect()
            ->route('pemberian_obats.index')
            ->with('success', 'Data pemberian obat berhasil dihapus!');
    }

    public function cetak(int $id): View
    {
        $pemberianObat = PemberianObat::with(['pasien', 'obat.informasiObat'])->findOrFail($id);

        return view('pemberian_obats.cetak', compact('pemberianObat'));
    }

    public function getObatInfo(int $id)
    {
        $obat = Obat::with('informasiObat')->findOrFail($id);
        $info = $obat->informasiObat;

        if (! $info) {
            return response()->json([]);
        }

        $halKhusus = [];

        if ($info->tidak_hentikan_mendadak) {
            $halKhusus[] = 'Tidak boleh dihentikan mendadak';
        }

        if ($info->harus_dihabiskan) {
            $halKhusus[] = 'Harus dihabiskan sesuai resep';
        }

        return response()->json([
            'nama_obat' => $obat->nama_obat,
            'bentuk_sediaan' => $obat->bentuk_sediaan,
            'kekuatan_dosis' => $obat->kekuatan_dosis,
            'stok' => $obat->stok,
            'indikasi_penyakit' => $info->indikasi_penyakit,
            'efek_samping_umum' => $info->efek_samping_umum,
            'tanda_bahaya' => $info->tanda_bahaya,
            'interaksi_obat' => $info->interaksi_obat,
            'interaksi_makanan' => $info->interaksi_makanan,
            'penyimpanan_suhu' => $info->penyimpanan_suhu,
            'hindari_cahaya' => $info->hindari_cahaya,
            'hindari_kelembaban' => $info->hindari_kelembaban,
            'hal_khusus' => implode(', ', $halKhusus),
            'cara_penggunaan_khusus' => $info->cara_penggunaan_khusus,
        ]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'pasien_id' => ['required', 'integer', 'exists:pasiens,id'],
            'obat_id' => ['required', 'integer', 'exists:obats,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'berapa_kali_sehari' => ['required', 'integer', 'min:1', 'max:10'],
            'sebelum_sesudah_makan' => ['required', 'in:sebelum makan,sesudah makan,tidak berpengaruh'],
            'lama_penggunaan_hari' => ['required', 'integer', 'min:1', 'max:365'],
            'informasi_tambahan' => ['nullable', 'string'],
            'tanggal_pemberian' => ['required', 'date'],
            'diagnosa_keluhan' => ['required', 'string'],
        ]);
    }
}
