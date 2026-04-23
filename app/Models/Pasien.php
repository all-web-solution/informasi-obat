<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'umur',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat'
    ];

    // Relasi ke pemberianObat (jika ada)
    public function pemberianObat()
    {
        return $this->hasMany(PemberianObat::class);
    }
}
