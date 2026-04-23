<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = ['nama_obat', 'bentuk_sediaan', 'kekuatan_dosis', 'stok'];

    public function informasiObat()
    {
        return $this->hasOne(InformasiObat::class);
    }

    public function pemberianObat()
    {
        return $this->hasMany(PemberianObat::class);
    }
}
