<?php

namespace App\Http\Controllers;


use App\Models\Pasien;
use App\Models\Obat;
use App\Models\PemberianObat;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function cetakPasien(Request $request)
    {
        $query = Pasien::query();

        if ($request->filled('filter_nama')) {
            $query->where('nama', 'like', '%' . $request->filter_nama . '%');
        }
        if ($request->filled('filter_jk')) {
            $query->where('jenis_kelamin', $request->filter_jk);
        }

        $pasiens = $query->orderBy('nama')->get();

        return view('cetak.laporan-pasien', compact('pasiens'));
    }

    public function cetakObat(Request $request)
    {
        $query = Obat::with('informasiObat');

        if ($request->filled('filter_nama_obat')) {
            $query->where('nama_obat', 'like', '%' . $request->filter_nama_obat . '%');
        }
        if ($request->filled('filter_bentuk')) {
            $query->where('bentuk_sediaan', $request->filter_bentuk);
        }

        $obats = $query->orderBy('nama_obat')->get();

        return view('cetak.laporan-obat', compact('obats'));
    }

    public function cetakPemberian(Request $request)
    {
        $query = PemberianObat::with(['pasien', 'obat']);

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pemberian', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pemberian', '<=', $request->end_date);
        }

        $pemberianObats = $query->orderBy('tanggal_pemberian', 'desc')->get();
        $total = $pemberianObats->sum('jumlah');

        return view('cetak.laporan-pemberian', compact('pemberianObats', 'total'));
    }
}
