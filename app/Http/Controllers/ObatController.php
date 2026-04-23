<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\InformasiObat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::with('informasiObat');

        // Filter berdasarkan nama obat
        if ($request->filled('filter_nama_obat')) {
            $query->where('nama_obat', 'like', '%' . $request->filter_nama_obat . '%');
        }

        // Filter berdasarkan bentuk sediaan
        if ($request->filled('filter_bentuk')) {
            $query->where('bentuk_sediaan', $request->filter_bentuk);
        }

        // Filter berdasarkan stok (menipis)
        if ($request->filled('filter_stok')) {
            if ($request->filter_stok == 'menipis') {
                $query->where('stok', '<', 10);
            } elseif ($request->filter_stok == 'habis') {
                $query->where('stok', 0);
            } elseif ($request->filter_stok == 'tersedia') {
                $query->where('stok', '>', 0);
            }
        }

        // Filter berdasarkan range stok
        if ($request->filled('filter_stok_min')) {
            $query->where('stok', '>=', $request->filter_stok_min);
        }
        if ($request->filled('filter_stok_max')) {
            $query->where('stok', '<=', $request->filter_stok_max);
        }

        $obats = $query->latest()->paginate(10);
        $obats->appends($request->all());

        return view('obats.index', compact('obats'));
    }
    public function cetak($id)
    {
        $obat = Obat::with('informasiObat')->findOrFail($id);
        return view('obats.cetak', compact('obat'));
    }

    public function create()
    {
        return view('obats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Data Obat
            'nama_obat' => 'required|string|max:150',
            'bentuk_sediaan' => 'required|in:tablet,kapsul,sirup,salep,krim, injeksi,lainnya',
            'kekuatan_dosis' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',

            // Informasi Obat
            'indikasi_penyakit' => 'required|string',
            'efek_samping_umum' => 'required|string',
            'tanda_bahaya' => 'required|string',
            'interaksi_obat' => 'required|string',
            'interaksi_makanan' => 'required|string',
            'penyimpanan_suhu' => 'required|in:rak,kulkas',
            'hindari_cahaya' => 'nullable|boolean',
            'hindari_kelembaban' => 'nullable|boolean',
            'tidak_hentikan_mendadak' => 'nullable|boolean',
            'harus_dihabiskan' => 'nullable|boolean',
            'cara_penggunaan_khusus' => 'nullable|string'
        ]);

        // Simpan data obat
        $obat = Obat::create([
            'nama_obat' => $request->nama_obat,
            'bentuk_sediaan' => $request->bentuk_sediaan,
            'kekuatan_dosis' => $request->kekuatan_dosis,
            'stok' => $request->stok
        ]);

        // Simpan informasi obat
        InformasiObat::create([
            'obat_id' => $obat->id,
            'indikasi_penyakit' => $request->indikasi_penyakit,
            'efek_samping_umum' => $request->efek_samping_umum,
            'tanda_bahaya' => $request->tanda_bahaya,
            'interaksi_obat' => $request->interaksi_obat,
            'interaksi_makanan' => $request->interaksi_makanan,
            'penyimpanan_suhu' => $request->penyimpanan_suhu,
            'hindari_cahaya' => $request->has('hindari_cahaya'),
            'hindari_kelembaban' => $request->has('hindari_kelembaban'),
            'tidak_hentikan_mendadak' => $request->has('tidak_hentikan_mendadak'),
            'harus_dihabiskan' => $request->has('harus_dihabiskan'),
            'cara_penggunaan_khusus' => $request->cara_penggunaan_khusus
        ]);

        return redirect()->route('obats.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $obat = Obat::with('informasiObat')->findOrFail($id);
        return view('obats.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:150',
            'bentuk_sediaan' => 'required|in:tablet,kapsul,sirup,salep,krim, injeksi,lainnya',
            'kekuatan_dosis' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'indikasi_penyakit' => 'required|string',
            'efek_samping_umum' => 'required|string',
            'tanda_bahaya' => 'required|string',
            'interaksi_obat' => 'required|string',
            'interaksi_makanan' => 'required|string',
            'penyimpanan_suhu' => 'required|in:rak,kulkas',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'bentuk_sediaan' => $request->bentuk_sediaan,
            'kekuatan_dosis' => $request->kekuatan_dosis,
            'stok' => $request->stok
        ]);

        // Update atau create informasi obat
        $informasi = InformasiObat::where('obat_id', $obat->id)->first();
        if ($informasi) {
            $informasi->update([
                'indikasi_penyakit' => $request->indikasi_penyakit,
                'efek_samping_umum' => $request->efek_samping_umum,
                'tanda_bahaya' => $request->tanda_bahaya,
                'interaksi_obat' => $request->interaksi_obat,
                'interaksi_makanan' => $request->interaksi_makanan,
                'penyimpanan_suhu' => $request->penyimpanan_suhu,
                'hindari_cahaya' => $request->has('hindari_cahaya'),
                'hindari_kelembaban' => $request->has('hindari_kelembaban'),
                'tidak_hentikan_mendadak' => $request->has('tidak_hentikan_mendadak'),
                'harus_dihabiskan' => $request->has('harus_dihabiskan'),
                'cara_penggunaan_khusus' => $request->cara_penggunaan_khusus
            ]);
        } else {
            InformasiObat::create([
                'obat_id' => $obat->id,
                'indikasi_penyakit' => $request->indikasi_penyakit,
                'efek_samping_umum' => $request->efek_samping_umum,
                'tanda_bahaya' => $request->tanda_bahaya,
                'interaksi_obat' => $request->interaksi_obat,
                'interaksi_makanan' => $request->interaksi_makanan,
                'penyimpanan_suhu' => $request->penyimpanan_suhu,
                'hindari_cahaya' => $request->has('hindari_cahaya'),
                'hindari_kelembaban' => $request->has('hindari_kelembaban'),
                'tidak_hentikan_mendadak' => $request->has('tidak_hentikan_mendadak'),
                'harus_dihabiskan' => $request->has('harus_dihabiskan'),
                'cara_penggunaan_khusus' => $request->cara_penggunaan_khusus
            ]);
        }

        return redirect()->route('obats.index')->with('success', 'Data obat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obats.index')->with('success', 'Data obat berhasil dihapus!');
    }

    public function show($id)
    {
        $obat = Obat::with('informasiObat')->findOrFail($id);
        return view('obats.show', compact('obat'));
    }
}
