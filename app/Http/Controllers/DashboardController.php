<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Obat;
use App\Models\PemberianObat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan nama pasien
        $searchNama = $request->get('search_nama');

        $totalPasien = Pasien::count();
        $totalObat = Obat::count();
        $totalPemberian = PemberianObat::count();
        $stokMenipis = Obat::where('stok', '<', 10)->count();

        // Query pemberian terbaru dengan filter
        $pemberianQuery = PemberianObat::with(['pasien', 'obat']);

        if ($searchNama) {
            $pemberianQuery->whereHas('pasien', function ($q) use ($searchNama) {
                $q->where('nama', 'like', '%' . $searchNama . '%');
            });
        }

        $pemberianTerbaru = $pemberianQuery->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPasien',
            'totalObat',
            'totalPemberian',
            'stokMenipis',
            'pemberianTerbaru',
            'searchNama'
        ));
    }

    public function cetak()
    {
        $totalPasien = Pasien::count();
        $totalObat = Obat::count();
        $totalPemberian = PemberianObat::count();
        $stokMenipis = Obat::where('stok', '<', 10)->get();
        $pemberianTerbaru = PemberianObat::with(['pasien', 'obat'])->latest()->take(20)->get();
        $obatTerlaris = PemberianObat::select('obat_id', \DB::raw('SUM(jumlah) as total'))
            ->groupBy('obat_id')
            ->with('obat')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('cetak.dashboard', compact('totalPasien', 'totalObat', 'totalPemberian', 'stokMenipis', 'pemberianTerbaru', 'obatTerlaris'));
    }
}
