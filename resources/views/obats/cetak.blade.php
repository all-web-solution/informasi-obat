{{-- resources/views/obats/cetak.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Informasi Obat - {{ $obat->nama_obat }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; background: white; }
        .cetak-container { max-width: 900px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #2e7d32; padding-bottom: 20px; }
        .header h1 { color: #1a5f1a; }
        .info-box { border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 20px; background: #f9f9f9; }
        .info-title { background: #2e7d32; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; }
        .info-label { font-weight: bold; color: #2e7d32; display: inline-block; width: 180px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: top; }
        th { background: #e8f5e9; color: #1a5f1a; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; }
        .btn-print { background: #2e7d32; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-bottom: 20px; }
        @media print { .no-print { display: none; } body { padding: 0; } }
    </style>
</head>
<body>
    <div class="cetak-container">
        <div class="no-print" style="text-align: center;">
            <button class="btn-print" onclick="window.print()">🖨️ Cetak / Print</button>
            <button class="btn-print" onclick="window.close()" style="background: #666;">Tutup</button>
        </div>
        
        <div class="header">
            <h1>🏥 SISTEM INFORMASI OBAT</h1>
            <p>INFORMASI LENGKAP OBAT</p>
            <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
        </div>
        
        <div class="info-box">
            <div class="info-title">📋 DATA DASAR OBAT</div>
            <p><span class="info-label">Nama Obat:</span> {{ $obat->nama_obat }}</p>
            <p><span class="info-label">Bentuk Sediaan:</span> {{ $obat->bentuk_sediaan }}</p>
            <p><span class="info-label">Kekuatan Dosis:</span> {{ $obat->kekuatan_dosis }}</p>
            <p><span class="info-label">Stok Saat Ini:</span> {{ $obat->stok }} unit</p>
        </div>
        
        @if($obat->informasiObat)
        @php $info = $obat->informasiObat; @endphp
        
        <div class="info-box">
            <div class="info-title">💊 INDIKASI & PENGGUNAAN</div>
            <table>
                <tr><th width="180">Indikasi (Penyakit):</th><td>{{ $info->indikasi_penyakit }}</td></tr>
                <tr><th>Efek Samping Umum:</th><td>{{ $info->efek_samping_umum }}</td></tr>
                <tr><th>Tanda Bahaya (Ke Dokter):</th><td class="text-danger">{{ $info->tanda_bahaya }}</td></tr>
            </table>
        </div>
        
        <div class="info-box">
            <div class="info-title">⚠️ INTERAKSI OBAT</div>
            <table>
                <tr><th>Interaksi dengan Obat Lain:</th><td>{{ $info->interaksi_obat }}</td></tr>
                <tr><th>Interaksi dengan Makanan/Minuman:</th><td>{{ $info->interaksi_makanan }}</td></tr>
            </table>
        </div>
        
        <div class="info-box">
            <div class="info-title">📦 PENYIMPANAN</div>
            <p><span class="info-label">Suhu Penyimpanan:</span> {{ $info->penyimpanan_suhu == 'rak' ? 'Suhu Rak (15-30°C)' : 'Kulkas (2-8°C)' }}</p>
            <p><span class="info-label">Hindari:</span> 
                @if($info->hindari_cahaya) Cahaya langsung, @endif
                @if($info->hindari_kelembaban) Kelembaban @endif
                @if(!$info->hindari_cahaya && !$info->hindari_kelembaban) - @endif
            </p>
        </div>
        
        <div class="info-box">
            <div class="info-title">🔔 HAL KHUSUS</div>
            <p>• {!! $info->tidak_hentikan_mendadak ? '⚠️ <strong>Tidak boleh dihentikan mendadak</strong>' : '✓ Dapat dihentikan sesuai kebutuhan' !!}</p>
            <p>• {!! $info->harus_dihabiskan ? '✓ <strong>Harus dihabiskan sesuai resep</strong>' : '⚠️ Tidak harus dihabiskan (sesuai kebutuhan)' !!}</p>
            @if($info->cara_penggunaan_khusus)
            <p>• <strong>Cara Penggunaan Khusus:</strong> {{ $info->cara_penggunaan_khusus }}</p>
            @endif
        </div>
        @endif
        
        <div class="footer">
            <p>Informasi ini penting untuk keselamatan pasien. Simpan sebagai referensi.</p>
        </div>
    </div>
</body>
</html>