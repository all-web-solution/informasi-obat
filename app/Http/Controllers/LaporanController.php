<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\PemberianObat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $this->filters($request);

        $pemberianQuery = $this->basePemberianQuery($filters);

        $summary = [
            'total_pasien' => Pasien::count(),
            'total_obat' => Obat::count(),
            'total_pemberian' => (clone $pemberianQuery)->count(),
            'total_jumlah_obat_diberikan' => (clone $pemberianQuery)->sum('jumlah'),
            'stok_menipis' => Obat::where('stok', '>', 0)->where('stok', '<=', 10)->count(),
            'stok_habis' => Obat::where('stok', 0)->count(),
        ];

        $pemberianPerHari = (clone $pemberianQuery)
            ->selectRaw('tanggal_pemberian, COUNT(*) as total')
            ->groupBy('tanggal_pemberian')
            ->orderBy('tanggal_pemberian')
            ->get();

        $topObats = PemberianObat::query()
            ->selectRaw('obat_id, COUNT(*) as total_pemberian, SUM(jumlah) as total_jumlah')
            ->with('obat:id,nama_obat,bentuk_sediaan,kekuatan_dosis,stok')
            ->when($filters['tanggal_awal'], fn (Builder $query) => $query->whereDate('tanggal_pemberian', '>=', $filters['tanggal_awal']))
            ->when($filters['tanggal_akhir'], fn (Builder $query) => $query->whereDate('tanggal_pemberian', '<=', $filters['tanggal_akhir']))
            ->groupBy('obat_id')
            ->orderByDesc('total_pemberian')
            ->limit(5)
            ->get();

        $topPasiens = PemberianObat::query()
            ->selectRaw('pasien_id, COUNT(*) as total_pemberian')
            ->with('pasien:id,nama,umur,jenis_kelamin')
            ->when($filters['tanggal_awal'], fn (Builder $query) => $query->whereDate('tanggal_pemberian', '>=', $filters['tanggal_awal']))
            ->when($filters['tanggal_akhir'], fn (Builder $query) => $query->whereDate('tanggal_pemberian', '<=', $filters['tanggal_akhir']))
            ->groupBy('pasien_id')
            ->orderByDesc('total_pemberian')
            ->limit(5)
            ->get();

        $stokKritis = Obat::query()
            ->with('informasiObat:id,obat_id,penyimpanan_suhu,harus_dihabiskan,tidak_hentikan_mendadak')
            ->where('stok', '<=', 10)
            ->orderBy('stok')
            ->orderBy('nama_obat')
            ->limit(10)
            ->get();

        $obatPerluPerhatian = Obat::query()
            ->whereHas('informasiObat', function (Builder $query) {
                $query->where('harus_dihabiskan', true)
                    ->orWhere('tidak_hentikan_mendadak', true)
                    ->orWhere('hindari_cahaya', true)
                    ->orWhere('hindari_kelembaban', true)
                    ->orWhere('penyimpanan_suhu', 'kulkas');
            })
            ->with('informasiObat')
            ->orderBy('nama_obat')
            ->limit(10)
            ->get();

        $komposisiPasien = [
            'laki_laki' => Pasien::where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => Pasien::where('jenis_kelamin', 'Perempuan')->count(),
        ];

        $latestPemberian = (clone $pemberianQuery)
            ->with([
                'pasien:id,nama,umur,jenis_kelamin',
                'obat:id,nama_obat,bentuk_sediaan,kekuatan_dosis,stok',
            ])
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return view('laporan', compact(
            'filters',
            'summary',
            'pemberianPerHari',
            'topObats',
            'topPasiens',
            'stokKritis',
            'obatPerluPerhatian',
            'komposisiPasien',
            'latestPemberian'
        ));
    }

    public function cetakPasien(Request $request): View
    {
        $filters = $this->filters($request);

        $pasiens = Pasien::query()
            ->withCount('pemberianObat')
            ->orderBy('nama')
            ->get();

        return view('laporan.cetak-pasien', compact('filters', 'pasiens'));
    }

    public function cetakObat(Request $request): View
    {
        $filters = $this->filters($request);

        $obats = Obat::query()
            ->with('informasiObat')
            ->withCount('pemberianObat')
            ->orderBy('nama_obat')
            ->get();

        return view('laporan.cetak-obat', compact('filters', 'obats'));
    }

    public function cetakPemberian(Request $request): View
    {
        $filters = $this->filters($request);

        $pemberianObats = $this->basePemberianQuery($filters)
            ->with([
                'pasien:id,nama,umur,jenis_kelamin',
                'obat:id,nama_obat,bentuk_sediaan,kekuatan_dosis',
            ])
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->get();

        return view('laporan.cetak-pemberian', compact('filters', 'pemberianObats'));
    }

    private function filters(Request $request): array
    {
        return $request->validate([
            'tanggal_awal' => ['nullable', 'date'],
            'tanggal_akhir' => ['nullable', 'date', 'after_or_equal:tanggal_awal'],
        ]) + [
            'tanggal_awal' => null,
            'tanggal_akhir' => null,
        ];
    }

    private function basePemberianQuery(array $filters): Builder
    {
        return PemberianObat::query()
            ->when($filters['tanggal_awal'], fn (Builder $query) => $query->whereDate('tanggal_pemberian', '>=', $filters['tanggal_awal']))
            ->when($filters['tanggal_akhir'], fn (Builder $query) => $query->whereDate('tanggal_pemberian', '<=', $filters['tanggal_akhir']));
    }
}
