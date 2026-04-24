<?php

namespace App\Http\Controllers;

use App\Models\InformasiObat;
use App\Models\Obat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ObatController extends Controller
{
    public function index(Request $request): View
    {
        $query = Obat::with('informasiObat');

        if ($request->filled('filter_nama_obat')) {
            $query->where('nama_obat', 'like', '%' . $request->filter_nama_obat . '%');
        }

        if ($request->filled('filter_bentuk')) {
            $query->where('bentuk_sediaan', $request->filter_bentuk);
        }

        if ($request->filled('filter_stok')) {
            match ($request->filter_stok) {
                'menipis' => $query->where('stok', '<', 10)->where('stok', '>', 0),
                'habis' => $query->where('stok', 0),
                'tersedia' => $query->where('stok', '>', 0),
                default => null,
            };
        }

        $obats = $query
            ->orderBy('nama_obat')
            ->paginate(10)
            ->withQueryString();

        return view('obats.index', compact('obats'));
    }

    public function create(): View
    {
        return view('obats.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        DB::transaction(function () use ($validated) {
            $obat = Obat::create([
                'nama_obat' => $validated['nama_obat'],
                'bentuk_sediaan' => $validated['bentuk_sediaan'],
                'kekuatan_dosis' => $validated['kekuatan_dosis'],
                'stok' => $validated['stok'],
            ]);

            InformasiObat::create([
                'obat_id' => $obat->id,
                'indikasi_penyakit' => $validated['indikasi_penyakit'],
                'efek_samping_umum' => $validated['efek_samping_umum'],
                'tanda_bahaya' => $validated['tanda_bahaya'],
                'interaksi_obat' => $validated['interaksi_obat'],
                'interaksi_makanan' => $validated['interaksi_makanan'],
                'penyimpanan_suhu' => $validated['penyimpanan_suhu'],
                'hindari_cahaya' => (bool) ($validated['hindari_cahaya'] ?? false),
                'hindari_kelembaban' => (bool) ($validated['hindari_kelembaban'] ?? false),
                'tidak_hentikan_mendadak' => (bool) ($validated['tidak_hentikan_mendadak'] ?? false),
                'harus_dihabiskan' => (bool) ($validated['harus_dihabiskan'] ?? false),
                'cara_penggunaan_khusus' => $validated['cara_penggunaan_khusus'] ?? null,
            ]);
        });

        return redirect()
            ->route('obats.index')
            ->with('success', 'Data obat berhasil ditambahkan!');
    }

    public function show(int $id): View
    {
        $obat = Obat::with('informasiObat')->findOrFail($id);

        return view('obats.show', compact('obat'));
    }

    public function edit(int $id): View
    {
        $obat = Obat::with('informasiObat')->findOrFail($id);

        return view('obats.edit', compact('obat'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $this->validateData($request);

        DB::transaction(function () use ($validated, $id) {
            $obat = Obat::findOrFail($id);

            $obat->update([
                'nama_obat' => $validated['nama_obat'],
                'bentuk_sediaan' => $validated['bentuk_sediaan'],
                'kekuatan_dosis' => $validated['kekuatan_dosis'],
                'stok' => $validated['stok'],
            ]);

            InformasiObat::updateOrCreate(
                ['obat_id' => $obat->id],
                [
                    'indikasi_penyakit' => $validated['indikasi_penyakit'],
                    'efek_samping_umum' => $validated['efek_samping_umum'],
                    'tanda_bahaya' => $validated['tanda_bahaya'],
                    'interaksi_obat' => $validated['interaksi_obat'],
                    'interaksi_makanan' => $validated['interaksi_makanan'],
                    'penyimpanan_suhu' => $validated['penyimpanan_suhu'],
                    'hindari_cahaya' => (bool) ($validated['hindari_cahaya'] ?? false),
                    'hindari_kelembaban' => (bool) ($validated['hindari_kelembaban'] ?? false),
                    'tidak_hentikan_mendadak' => (bool) ($validated['tidak_hentikan_mendadak'] ?? false),
                    'harus_dihabiskan' => (bool) ($validated['harus_dihabiskan'] ?? false),
                    'cara_penggunaan_khusus' => $validated['cara_penggunaan_khusus'] ?? null,
                ]
            );
        });

        return redirect()
            ->route('obats.index')
            ->with('success', 'Data obat berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $obat = Obat::findOrFail($id);

        if ($obat->pemberianObat()->exists()) {
            return back()->with('error', 'Obat tidak dapat dihapus karena sudah digunakan dalam data pemberian obat.');
        }

        $obat->delete();

        return redirect()
            ->route('obats.index')
            ->with('success', 'Data obat berhasil dihapus!');
    }

    public function cetak(int $id): View
    {
        $obat = Obat::with('informasiObat')->findOrFail($id);

        return view('obats.cetak', compact('obat'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama_obat' => ['required', 'string', 'max:150'],
            'bentuk_sediaan' => ['required', 'in:tablet,kapsul,sirup,salep,krim,injeksi,sachet,lainnya'],
            'kekuatan_dosis' => ['required', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'min:0'],

            'indikasi_penyakit' => ['required', 'string'],
            'efek_samping_umum' => ['required', 'string'],
            'tanda_bahaya' => ['required', 'string'],
            'interaksi_obat' => ['required', 'string'],
            'interaksi_makanan' => ['required', 'string'],
            'penyimpanan_suhu' => ['required', 'in:rak,kulkas'],

            'hindari_cahaya' => ['nullable', 'boolean'],
            'hindari_kelembaban' => ['nullable', 'boolean'],
            'tidak_hentikan_mendadak' => ['nullable', 'boolean'],
            'harus_dihabiskan' => ['nullable', 'boolean'],
            'cara_penggunaan_khusus' => ['nullable', 'string'],
        ]);
    }
}
