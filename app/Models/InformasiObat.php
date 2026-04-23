<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiObat extends Model
{
    protected $table = 'informasi_obats';
    protected $fillable = [
        'obat_id',
        'indikasi_penyakit',
        'efek_samping_umum',
        'tanda_bahaya',
        'interaksi_obat',
        'interaksi_makanan',
        'penyimpanan_suhu',
        'hindari_cahaya',
        'hindari_kelembaban',
        'tidak_hentikan_mendadak',
        'harus_dihabiskan',
        'cara_penggunaan_khusus'
    ];

    protected $casts = [
        'hindari_cahaya' => 'boolean',
        'hindari_kelembaban' => 'boolean',
        'tidak_hentikan_mendadak' => 'boolean',
        'harus_dihabiskan' => 'boolean',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
