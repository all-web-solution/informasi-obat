<?php
// routes/web.php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PemberianObatController;
use Illuminate\Support\Facades\Route;
use App\Models\Obat;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');

Route::resource('pasiens', PasienController::class);
Route::resource('obats', ObatController::class);
Route::resource('pemberian_obats', PemberianObatController::class);
// routes/web.php - tambahkan ini
Route::resource('obats', ObatController::class);

// AJAX route untuk mendapatkan informasi obat
Route::get('/get-obat-info/{id}', function ($id) {
    $obat = Obat::with('informasiObat')->find($id);
    if ($obat && $obat->informasiObat) {
        $info = $obat->informasiObat;
        $halKhusus = [];
        if ($info->tidak_hentikan_mendadak) $halKhusus[] = "Tidak boleh dihentikan mendadak";
        if ($info->harus_dihabiskan) $halKhusus[] = "Harus dihabiskan sesuai resep";

        return response()->json([
            'indikasi_penyakit' => $info->indikasi_penyakit,
            'efek_samping_umum' => $info->efek_samping_umum,
            'tanda_bahaya' => $info->tanda_bahaya,
            'interaksi_obat' => $info->interaksi_obat,
            'interaksi_makanan' => $info->interaksi_makanan,
            'penyimpanan_suhu' => $info->penyimpanan_suhu,
            'hindari_cahaya' => $info->hindari_cahaya,
            'hindari_kelembaban' => $info->hindari_kelembaban,
            'hal_khusus' => implode(', ', $halKhusus),
            'cara_penggunaan_khusus' => $info->cara_penggunaan_khusus
        ]);
    }
    return response()->json([]);
});


Route::get('/cetak/pasien/{id}', [PasienController::class, 'cetak'])->name('pasiens.cetak');
Route::get('/cetak/obat/{id}', [ObatController::class, 'cetak'])->name('obats.cetak');
Route::get('/cetak/pemberian/{id}', [PemberianObatController::class, 'cetak'])->name('pemberian_obats.cetak');
Route::get('/cetak/laporan-pasien', [LaporanController::class, 'cetakPasien'])->name('cetak.pasien');
Route::get('/cetak/laporan-obat', [LaporanController::class, 'cetakObat'])->name('cetak.obat');
Route::get('/cetak/laporan-pemberian', [LaporanController::class, 'cetakPemberian'])->name('cetak.pemberian');
Route::get('/cetak/dashboard', [DashboardController::class, 'cetak'])->name('cetak.dashboard');
