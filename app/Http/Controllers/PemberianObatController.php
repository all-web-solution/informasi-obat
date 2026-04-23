<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\PemberianObat;
use Illuminate\Http\Request;

class PemberianObatController extends Controller
{
    public function index(Request $request)
    {
        $query = PemberianObat::with('pasien');

        if ($request->filled('filter_pasien')) {
            $query->where('pasien_id', $request->filter_pasien);
        }

        if ($request->filled('filter_tanggal')) {
            $query->whereDate('tanggal_pemberian', $request->filter_tanggal);
        }

        $pemberianObats = $query->latest()->paginate(10);
        $pemberianObats->appends($request->all());

        $pasiens = Pasien::orderBy('nama')->get();

        return view('pemberian_obats.index', compact('pemberianObats', 'pasiens'));
    }

    public function create()
    {
        $pasiens = Pasien::orderBy('nama')->get();
        return view('pemberian_obats.create', compact('pasiens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'obat' => 'required|string',
            'berapa_kali_sehari' => 'required|integer|min:1|max:10',
            'sebelum_sesudah_makan' => 'required|in:sebelum makan,sesudah makan,tidak berpengaruh',
            'lama_penggunaan_hari' => 'required|integer|min:1|max:365',
            'informasi_tambahan' => 'nullable|string',
            'tanggal_pemberian' => 'required|date',
            'diagnosa_keluhan' => 'required|string',
        ]);

        PemberianObat::create($request->all());

        return redirect()->route('pemberian_obats.index')
            ->with('success', 'Data pemberian obat berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pemberianObat = PemberianObat::with('pasien')->findOrFail($id);
        return view('pemberian_obats.show', compact('pemberianObat'));
    }

    public function edit($id)
    {
        $pemberianObat = PemberianObat::findOrFail($id);
        $pasiens = Pasien::orderBy('nama')->get();
        return view('pemberian_obats.edit', compact('pemberianObat', 'pasiens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'obat' => 'required|string',
            'berapa_kali_sehari' => 'required|integer|min:1|max:10',
            'sebelum_sesudah_makan' => 'required|in:sebelum makan,sesudah makan,tidak berpengaruh',
            'lama_penggunaan_hari' => 'required|integer|min:1|max:365',
            'informasi_tambahan' => 'nullable|string',
            'tanggal_pemberian' => 'required|date',
            'diagnosa_keluhan' => 'required|string',
        ]);

        $pemberianObat = PemberianObat::findOrFail($id);
        $pemberianObat->update($request->all());

        return redirect()->route('pemberian_obats.index')
            ->with('success', 'Data pemberian obat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pemberianObat = PemberianObat::findOrFail($id);
        $pemberianObat->delete();

        return redirect()->route('pemberian_obats.index')
            ->with('success', 'Data pemberian obat berhasil dihapus!');
    }

    public function cetak($id)
    {
        $pemberianObat = PemberianObat::with('pasien')->findOrFail($id);
        return view('pemberian_obats.cetak', compact('pemberianObat'));
    }
}
