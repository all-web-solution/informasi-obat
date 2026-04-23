<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function cetak($id)
    {
        $pasien = Pasien::with('pemberianObat.obat')->findOrFail($id);
        $totalPemberian = $pasien->pemberianObat->count();
        $riwayatObat = $pasien->pemberianObat()->with('obat')->latest()->get();

        return view('pasiens.cetak', compact('pasien', 'totalPemberian', 'riwayatObat'));
    }

    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->filled('filter_nama')) {
            $query->where('nama', 'like', '%' . $request->filter_nama . '%');
        }
        if ($request->filled('filter_jk')) {
            $query->where('jenis_kelamin', $request->filter_jk);
        }
        if ($request->filled('filter_umur_min')) {
            $query->where('umur', '>=', $request->filter_umur_min);
        }
        if ($request->filled('filter_umur_max')) {
            $query->where('umur', '<=', $request->filter_umur_max);
        }

        $pasiens = $query->latest()->paginate(10);
        $pasiens->appends($request->all());

        return view('pasiens.index', compact('pasiens'));
    }

    public function create()
    {
        return view('pasiens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'umur' => 'required|integer|min:0|max:150',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            // Hapus 'diagnosa_keluhan'
        ]);

        Pasien::create($request->only([
            'nama',
            'umur',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat'
        ]));

        return redirect()->route('pasiens.index')->with('success', 'Data pasien berhasil ditambahkan!');
    }

    // DETAIL PASIEN - LENGKAP
    public function show($id)
    {
        $pasien = Pasien::with('pemberianObat.obat')->findOrFail($id);
        $totalPemberian = $pasien->pemberianObat->count();
        $riwayatObat = $pasien->pemberianObat()->with('obat')->latest()->take(10)->get();

        return view('pasiens.show', compact('pasien', 'totalPemberian', 'riwayatObat'));
    }

    // EDIT PASIEN - FORM
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasiens.edit', compact('pasien'));
    }

    // UPDATE PASIEN - PROSES
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'umur' => 'required|integer|min:0|max:150',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            // Hapus 'diagnosa_keluhan'
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->only([
            'nama',
            'umur',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat'
        ]));

        return redirect()->route('pasiens.index')->with('success', 'Data pasien berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasiens.index')->with('success', 'Data pasien berhasil dihapus!');
    }
}
