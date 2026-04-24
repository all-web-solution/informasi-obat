<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\PemberianObat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $searchNama = trim((string) $request->query('search_nama', ''));

        $totalPasien = Pasien::count();
        $totalObat = Obat::count();
        $totalPemberian = PemberianObat::count();

        $stokMenipis = Obat::where('stok', '>', 0)
            ->where('stok', '<=', 10)
            ->count();

        $stokHabis = Obat::where('stok', 0)->count();

        $pemberianBulanIni = PemberianObat::whereMonth('tanggal_pemberian', now()->month)
            ->whereYear('tanggal_pemberian', now()->year)
            ->count();

        $pemberianQuery = PemberianObat::query()
            ->with('pasien:id,nama,umur,jenis_kelamin');

        if ($searchNama !== '') {
            $pemberianQuery->where(function (Builder $query) use ($searchNama) {
                $query
                    ->where('obat_aturan_pakai', 'like', '%' . $searchNama . '%')
                    ->orWhere('diagnosa_keluhan', 'like', '%' . $searchNama . '%')
                    ->orWhereHas('pasien', function (Builder $patientQuery) use ($searchNama) {
                        $patientQuery->where('nama', 'like', '%' . $searchNama . '%');
                    });
            });
        }

        $pemberianTerbaru = $pemberianQuery
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $pasienTerbaru = Pasien::query()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'nama', 'umur', 'jenis_kelamin', 'created_at']);

        $stokKritis = Obat::query()
            ->where('stok', '<=', 10)
            ->orderBy('stok')
            ->orderBy('nama_obat')
            ->limit(5)
            ->get(['id', 'nama_obat', 'bentuk_sediaan', 'kekuatan_dosis', 'stok']);

        $pemberianPerHari = PemberianObat::query()
            ->selectRaw('tanggal_pemberian, COUNT(*) as total')
            ->whereDate('tanggal_pemberian', '>=', now()->subDays(14)->toDateString())
            ->groupBy('tanggal_pemberian')
            ->orderBy('tanggal_pemberian')
            ->get();

        $topPasien = PemberianObat::query()
            ->selectRaw('pasien_id, COUNT(*) as total_pemberian')
            ->with('pasien:id,nama,umur,jenis_kelamin')
            ->groupBy('pasien_id')
            ->orderByDesc('total_pemberian')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalPasien',
            'totalObat',
            'totalPemberian',
            'stokMenipis',
            'stokHabis',
            'pemberianBulanIni',
            'pemberianTerbaru',
            'pasienTerbaru',
            'stokKritis',
            'pemberianPerHari',
            'topPasien',
            'searchNama'
        ));
    }

    public function cetak(Request $request): View
    {
        $searchNama = trim((string) $request->query('search_nama', ''));

        $pemberianQuery = PemberianObat::query()
            ->with('pasien:id,nama,umur,jenis_kelamin');

        if ($searchNama !== '') {
            $pemberianQuery->where(function (Builder $query) use ($searchNama) {
                $query
                    ->where('obat_aturan_pakai', 'like', '%' . $searchNama . '%')
                    ->orWhere('diagnosa_keluhan', 'like', '%' . $searchNama . '%')
                    ->orWhereHas('pasien', function (Builder $patientQuery) use ($searchNama) {
                        $patientQuery->where('nama', 'like', '%' . $searchNama . '%');
                    });
            });
        }

        $summary = [
            'total_pasien' => Pasien::count(),
            'total_obat' => Obat::count(),
            'total_pemberian' => PemberianObat::count(),
            'stok_menipis' => Obat::where('stok', '>', 0)->where('stok', '<=', 10)->count(),
            'stok_habis' => Obat::where('stok', 0)->count(),
            'pemberian_bulan_ini' => PemberianObat::whereMonth('tanggal_pemberian', now()->month)
                ->whereYear('tanggal_pemberian', now()->year)
                ->count(),
        ];

        $pemberianTerbaru = $pemberianQuery
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->limit(20)
            ->get();

        $stokKritis = Obat::where('stok', '<=', 10)
            ->orderBy('stok')
            ->orderBy('nama_obat')
            ->get();

        return view('dashboard-cetak', compact(
            'summary',
            'pemberianTerbaru',
            'stokKritis',
            'searchNama'
        ));
    }
}
