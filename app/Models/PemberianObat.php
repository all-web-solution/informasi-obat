<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemberianObat extends Model
{
    protected $table = 'pemberian_obats';

    protected $fillable = [
        'pasien_id',
        'obat_aturan_pakai',
        'tanggal_pemberian',
        'diagnosa_keluhan',
        'informasi_tambahan',
    ];

    protected $casts = [
        'tanggal_pemberian' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function getRingkasanObatAttribute(): string
    {
        return str($this->obat_aturan_pakai)
            ->replace(["\r\n", "\r", "\n"], ' ')
            ->limit(120)
            ->toString();
    }
}
