<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'tanggal_pemberian'
    ];

    protected $casts = [
        'tanggal_pemberian' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function getInformasiLengkap()
    {
        $info = $this->obat->informasiObat;
        return (object)[
            'aturan_pakai' => "{$this->berapa_kali_sehari} kali sehari, {$this->sebelum_sesudah_makan}, {$this->lama_penggunaan_hari} hari",
            'indikasi' => $info->indikasi_penyakit ?? '-',
            'efek_samping' => $info->efek_samping_umum ?? '-',
            'tanda_bahaya' => $info->tanda_bahaya ?? '-',
            'interaksi_obat' => $info->interaksi_obat ?? '-',
            'interaksi_makanan' => $info->interaksi_makanan ?? '-',
            'penyimpanan' => $this->getPenyimpananText($info),
            'hal_khusus' => $this->getHalKhusus($info),
        ];
    }

    private function getPenyimpananText($info)
    {
        $text = "Suhu " . ($info->penyimpanan_suhu ?? 'rak');
        $hindari = [];
        if ($info->hindari_cahaya) $hindari[] = 'cahaya langsung';
        if ($info->hindari_kelembaban) $hindari[] = 'kelembaban';
        if (!empty($hindari)) $text .= ", hindari " . implode(' dan ', $hindari);
        return $text;
    }

    private function getHalKhusus($info)
    {
        $khusus = [];
        if ($info->tidak_hentikan_mendadak) $khusus[] = "⚠️ Tidak boleh dihentikan mendadak";
        if ($info->harus_dihabiskan) $khusus[] = "✓ Harus dihabiskan sesuai resep";
        if ($info->cara_penggunaan_khusus) $khusus[] = "📌 " . $info->cara_penggunaan_khusus;
        return $khusus;
    }
}
