<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Obat extends Model
{
    protected $fillable = [
        'nama_obat',
        'bentuk_sediaan',
        'kekuatan_dosis',
        'stok',
    ];

    public function informasiObat(): HasOne
    {
        return $this->hasOne(InformasiObat::class);
    }

    public function pemberianObat(): HasMany
    {
        return $this->hasMany(PemberianObat::class);
    }

    public function getNamaLengkapAttribute(): string
    {
        return "{$this->nama_obat} {$this->kekuatan_dosis} ({$this->bentuk_sediaan})";
    }
}
