<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemberianObat extends Model
{
    protected $table = 'pemberian_obats';

    protected $fillable = [
        'pasien_id',
        'obat_id',
        'jumlah',
        'berapa_kali_sehari',
        'sebelum_sesudah_makan',
        'lama_penggunaan_hari',
        'informasi_tambahan',
        'tanggal_pemberian',
        'diagnosa_keluhan',
    ];

    protected $casts = [
        'tanggal_pemberian' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }

    public function getNamaObatDisplayAttribute(): string
    {
        if (! $this->obat) {
            return '-';
        }

        return trim($this->obat->nama_obat . ' ' . $this->obat->kekuatan_dosis);
    }

    public function getDetailObatDisplayAttribute(): string
    {
        if (! $this->obat) {
            return '-';
        }

        return trim($this->obat->bentuk_sediaan . ' | Stok saat ini: ' . $this->obat->stok);
    }

    public function getAturanPakaiDisplayAttribute(): string
    {
        return "{$this->berapa_kali_sehari}x sehari, {$this->sebelum_sesudah_makan}, selama {$this->lama_penggunaan_hari} hari";
    }

    public function informasiLengkap(): object
    {
        $info = $this->obat?->informasiObat;

        return (object) [
            'aturan_pakai' => $this->aturan_pakai_display,
            'indikasi' => $info?->indikasi_penyakit ?? '-',
            'efek_samping' => $info?->efek_samping_umum ?? '-',
            'tanda_bahaya' => $info?->tanda_bahaya ?? '-',
            'interaksi_obat' => $info?->interaksi_obat ?? '-',
            'interaksi_makanan' => $info?->interaksi_makanan ?? '-',
            'penyimpanan' => $this->formatPenyimpanan($info),
            'hal_khusus' => $this->formatHalKhusus($info),
        ];
    }

    private function formatPenyimpanan(?InformasiObat $info): string
    {
        if (! $info) {
            return '-';
        }

        $text = $info->penyimpanan_suhu === 'kulkas'
            ? 'Simpan di kulkas'
            : 'Simpan pada suhu ruang/rak obat';

        $hindari = [];

        if ($info->hindari_cahaya) {
            $hindari[] = 'cahaya langsung';
        }

        if ($info->hindari_kelembaban) {
            $hindari[] = 'kelembaban';
        }

        if ($hindari !== []) {
            $text .= ', hindari ' . implode(' dan ', $hindari);
        }

        return $text;
    }

    private function formatHalKhusus(?InformasiObat $info): array
    {
        if (! $info) {
            return [];
        }

        $items = [];

        if ($info->tidak_hentikan_mendadak) {
            $items[] = 'Tidak boleh dihentikan mendadak';
        }

        if ($info->harus_dihabiskan) {
            $items[] = 'Harus dihabiskan sesuai aturan';
        }

        if ($info->cara_penggunaan_khusus) {
            $items[] = $info->cara_penggunaan_khusus;
        }

        return $items;
    }
}
