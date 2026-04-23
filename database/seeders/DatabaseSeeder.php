<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\InformasiObat;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Data Pasien
        Pasien::create([
            'nama' => 'Ahmad Fauzi',
            'umur' => 45,
            'tanggal_lahir' => '1979-03-15',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'diagnosa_keluhan' => 'Hipertensi grade 1, sakit kepala berdenyut'
        ]);

        // Data Obat
        $obat1 = Obat::create([
            'nama_obat' => 'Amlodipine',
            'bentuk_sediaan' => 'tablet',
            'kekuatan_dosis' => '10 mg',
            'stok' => 100
        ]);

        // Informasi Obat
        InformasiObat::create([
            'obat_id' => $obat1->id,
            'indikasi_penyakit' => 'Hipertensi (tekanan darah tinggi)',
            'efek_samping_umum' => 'Pusing, sakit kepala, bengkak pada pergelangan kaki',
            'tanda_bahaya' => 'Jantung berdebar tidak normal, sesak napas, pembengkakan wajah',
            'interaksi_obat' => 'Jangan dengan simvastatin dosis tinggi, rifampicin',
            'interaksi_makanan' => 'Hindari jus grapefruit',
            'penyimpanan_suhu' => 'rak',
            'hindari_cahaya' => true,
            'hindari_kelembaban' => true,
            'tidak_hentikan_mendadak' => true,
            'harus_dihabiskan' => false,
            'cara_penggunaan_khusus' => 'Minum pada jam yang sama setiap hari'
        ]);
    }
}
