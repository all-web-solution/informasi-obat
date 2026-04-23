<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatPemberian extends Model
{
    use HasFactory;

    protected $table = 'pemberian_obats';

    protected $fillable = [
        'pasien_id',
        'obat',
        'berapa_kali_sehari',
        'sebelum_sesudah_makan',
        'lama_penggunaan_hari',
        'informasi_tambahan',
        'tanggal_pemberian',
        'diagnosa_keluhan'
    ];

    protected $casts = [
        'tanggal_pemberian' => 'date',
        'lama_penggunaan_hari' => 'integer',
        'berapa_kali_sehari' => 'integer'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
