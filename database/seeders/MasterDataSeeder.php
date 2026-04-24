<?php

namespace Database\Seeders;

use App\Models\InformasiObat;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\PemberianObat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            PemberianObat::query()->delete();
            InformasiObat::query()->delete();
            Obat::query()->delete();
            Pasien::query()->delete();

            $pasiens = collect($this->pasiens())->map(fn (array $data) => Pasien::create($data));

            collect($this->obats())->each(function (array $data) {
                $info = $data['informasi'];
                unset($data['informasi']);

                $obat = Obat::create($data);

                InformasiObat::create(array_merge($info, [
                    'obat_id' => $obat->id,
                ]));
            });

            foreach ($this->pemberianObats($pasiens) as $data) {
                PemberianObat::create($data);
            }
        });
    }

    private function pasiens(): array
    {
        return [
            ['nama' => 'Budi Santoso', 'umur' => 42, 'tanggal_lahir' => '1984-03-12', 'jenis_kelamin' => 'Laki-laki', 'alamat' => 'Jl. Merpati No. 12, Semarang'],
            ['nama' => 'Siti Aminah', 'umur' => 35, 'tanggal_lahir' => '1991-07-21', 'jenis_kelamin' => 'Perempuan', 'alamat' => 'Jl. Kenanga No. 8, Semarang'],
            ['nama' => 'Agus Prasetyo', 'umur' => 51, 'tanggal_lahir' => '1975-11-02', 'jenis_kelamin' => 'Laki-laki', 'alamat' => 'Jl. Diponegoro No. 41, Semarang'],
            ['nama' => 'Dewi Lestari', 'umur' => 28, 'tanggal_lahir' => '1998-02-17', 'jenis_kelamin' => 'Perempuan', 'alamat' => 'Jl. Melati No. 5, Semarang'],
            ['nama' => 'Hadi Wijaya', 'umur' => 60, 'tanggal_lahir' => '1966-09-30', 'jenis_kelamin' => 'Laki-laki', 'alamat' => 'Jl. Veteran No. 19, Semarang'],
            ['nama' => 'Rina Marlina', 'umur' => 31, 'tanggal_lahir' => '1995-05-14', 'jenis_kelamin' => 'Perempuan', 'alamat' => 'Jl. Cendrawasih No. 22, Semarang'],
            ['nama' => 'Fajar Nugroho', 'umur' => 24, 'tanggal_lahir' => '2002-01-08', 'jenis_kelamin' => 'Laki-laki', 'alamat' => 'Jl. Anggrek No. 3, Semarang'],
            ['nama' => 'Nurhayati', 'umur' => 55, 'tanggal_lahir' => '1971-10-26', 'jenis_kelamin' => 'Perempuan', 'alamat' => 'Jl. Seroja No. 18, Semarang'],
            ['nama' => 'Wahyu Saputra', 'umur' => 39, 'tanggal_lahir' => '1987-08-19', 'jenis_kelamin' => 'Laki-laki', 'alamat' => 'Jl. Gajah Raya No. 77, Semarang'],
            ['nama' => 'Maya Permatasari', 'umur' => 46, 'tanggal_lahir' => '1980-12-04', 'jenis_kelamin' => 'Perempuan', 'alamat' => 'Jl. Pandanaran No. 10, Semarang'],
        ];
    }

    private function obats(): array
    {
        return [
            $this->obat('Paracetamol', 'tablet', '500 mg', 120, 'Demam dan nyeri ringan sampai sedang.', false, false),
            $this->obat('Amoxicillin', 'kapsul', '500 mg', 80, 'Infeksi bakteri sesuai indikasi medis.', true, false),
            $this->obat('Cetirizine', 'tablet', '10 mg', 65, 'Gejala alergi seperti gatal, bersin, dan urtikaria.', false, false),
            $this->obat('Omeprazole', 'kapsul', '20 mg', 45, 'Dispepsia, GERD, dan keluhan lambung.', false, false),
            $this->obat('Amlodipine', 'tablet', '5 mg', 30, 'Hipertensi dan kontrol tekanan darah.', false, true),
            $this->obat('Metformin', 'tablet', '500 mg', 55, 'Kontrol gula darah pada diabetes melitus tipe 2.', false, true),
            $this->obat('Salbutamol', 'tablet', '2 mg', 28, 'Meredakan bronkospasme sesuai indikasi medis.', false, false),
            $this->obat('Ibuprofen', 'tablet', '400 mg', 36, 'Nyeri ringan sampai sedang dan inflamasi.', false, false),
            $this->obat('Simvastatin', 'tablet', '20 mg', 22, 'Membantu mengontrol kadar kolesterol.', false, true),
            $this->obat('Oralit', 'sachet', '200 ml', 90, 'Mencegah dan mengatasi dehidrasi ringan akibat diare.', false, false),
        ];
    }

    private function obat(string $nama, string $bentuk, string $dosis, int $stok, string $indikasi, bool $harusDihabiskan, bool $janganStop): array
    {
        return [
            'nama_obat' => $nama,
            'bentuk_sediaan' => $bentuk,
            'kekuatan_dosis' => $dosis,
            'stok' => $stok,
            'informasi' => [
                'indikasi_penyakit' => $indikasi,
                'efek_samping_umum' => 'Mual ringan, pusing, atau keluhan saluran cerna dapat terjadi pada sebagian pasien.',
                'tanda_bahaya' => 'Segera periksa bila muncul sesak, ruam berat, bengkak wajah, atau keluhan berat lain.',
                'interaksi_obat' => 'Konsultasikan jika digunakan bersama obat rutin lain atau obat dengan risiko interaksi.',
                'interaksi_makanan' => 'Ikuti anjuran waktu minum dan hindari makanan/minuman yang memperburuk keluhan.',
                'penyimpanan_suhu' => 'rak',
                'hindari_cahaya' => true,
                'hindari_kelembaban' => true,
                'tidak_hentikan_mendadak' => $janganStop,
                'harus_dihabiskan' => $harusDihabiskan,
                'cara_penggunaan_khusus' => 'Gunakan sesuai aturan pakai dan instruksi tenaga kesehatan.',
            ],
        ];
    }

    private function pemberianObats($pasiens): array
    {
        $templates = [
            [
                'obat_aturan_pakai' => "Paracetamol 500 mg tablet\nAturan pakai: 3 x 1 tablet sesudah makan bila demam atau nyeri.\nJumlah: 10 tablet.",
                'diagnosa_keluhan' => 'Demam dan nyeri kepala sejak dua hari.',
            ],
            [
                'obat_aturan_pakai' => "Amoxicillin 500 mg kapsul\nAturan pakai: 3 x 1 kapsul sesudah makan selama 5 hari.\nJumlah: 15 kapsul.\nCatatan: antibiotik harus dihabiskan.",
                'diagnosa_keluhan' => 'Infeksi saluran napas atas dengan dahak kekuningan.',
            ],
            [
                'obat_aturan_pakai' => "Cetirizine 10 mg tablet\nAturan pakai: 1 x 1 tablet malam hari bila gatal atau bersin.\nJumlah: 7 tablet.",
                'diagnosa_keluhan' => 'Gatal dan bersin karena alergi.',
            ],
            [
                'obat_aturan_pakai' => "Omeprazole 20 mg kapsul\nAturan pakai: 1 x 1 kapsul pagi sebelum makan selama 14 hari.\nJumlah: 14 kapsul.",
                'diagnosa_keluhan' => 'Nyeri ulu hati dan mual setelah makan terlambat.',
            ],
            [
                'obat_aturan_pakai' => "Amlodipine 5 mg tablet\nAturan pakai: 1 x 1 tablet malam hari pada jam yang sama setiap hari.\nJumlah: 30 tablet.",
                'diagnosa_keluhan' => 'Hipertensi tidak terkontrol.',
            ],
            [
                'obat_aturan_pakai' => "Metformin 500 mg tablet\nAturan pakai: 2 x 1 tablet sesudah makan pagi dan malam.\nJumlah: 30 tablet.",
                'diagnosa_keluhan' => 'Keluhan gula darah tinggi dan mudah haus.',
            ],
            [
                'obat_aturan_pakai' => "Salbutamol 2 mg tablet\nAturan pakai: 3 x 1 tablet bila sesak sesuai anjuran tenaga kesehatan.\nJumlah: 10 tablet.",
                'diagnosa_keluhan' => 'Sesak ringan berulang sesuai riwayat bronkospasme.',
            ],
            [
                'obat_aturan_pakai' => "Ibuprofen 400 mg tablet\nAturan pakai: 2 x 1 tablet sesudah makan bila nyeri.\nJumlah: 10 tablet.",
                'diagnosa_keluhan' => 'Nyeri otot setelah aktivitas berat.',
            ],
            [
                'obat_aturan_pakai' => "Simvastatin 20 mg tablet\nAturan pakai: 1 x 1 tablet malam hari.\nJumlah: 30 tablet.",
                'diagnosa_keluhan' => 'Kontrol kolesterol rutin.',
            ],
            [
                'obat_aturan_pakai' => "Oralit sachet\nAturan pakai: larutkan 1 sachet dalam 200 ml air matang, diminum setiap selesai BAB cair.\nJumlah: 5 sachet.",
                'diagnosa_keluhan' => 'Diare cair sejak satu hari.',
            ],
        ];

        $data = [];

        for ($i = 0; $i < 24; $i++) {
            $template = $templates[$i % count($templates)];
            $pasien = $pasiens[$i % $pasiens->count()];

            $data[] = [
                'pasien_id' => $pasien->id,
                'obat_aturan_pakai' => $template['obat_aturan_pakai'],
                'tanggal_pemberian' => Carbon::now()->subDays(($i * 3) + 1)->format('Y-m-d'),
                'diagnosa_keluhan' => $template['diagnosa_keluhan'],
                'informasi_tambahan' => collect([
                    'Diminum sesuai aturan pakai.',
                    'Kontrol kembali bila keluhan belum membaik.',
                    'Perbanyak minum air putih dan istirahat cukup.',
                    'Segera kembali bila muncul tanda bahaya atau reaksi alergi.',
                ])->random(),
            ];
        }

        return $data;
    }
}
