{{-- resources/views/pasiens/cetak.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Pasien - {{ $pasien->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 20px;
            background: white;
        }
        .cetak-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2e7d32;
        }
        .header h1 {
            color: #1a5f1a;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin-top: 5px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-title {
            background: #e8f5e9;
            padding: 10px;
            font-weight: bold;
            color: #1a5f1a;
            border-left: 5px solid #2e7d32;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            width: 150px;
            display: inline-block;
        }
        .info-value {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #2e7d32;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #999;
        }
        .stamp {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .stamp div {
            text-align: center;
        }
        .sign-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 30px;
            padding-top: 5px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
        .btn-print {
            background: #2e7d32;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .btn-print:hover {
            background: #1a5f1a;
        }
    </style>
</head>
<body>
    <div class="cetak-container">
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button class="btn-print" onclick="window.print()">
                🖨️ Cetak / Print
            </button>
            <button class="btn-print" onclick="window.close()" style="background: #666;">
                Tutup
            </button>
        </div>
        
        <div class="header">
            <h1>🏥 SISTEM INFORMASI OBAT</h1>
            <p>Jl. Kesehatan No. 123, Telp. (021) 1234567</p>
            <h3>DATA PASIEN</h3>
            <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
        </div>
        
        <div class="info-section">
            <div class="info-title">IDENTITAS PASIEN</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap:</span>
                    <span class="info-value">{{ $pasien->nama }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">ID Pasien:</span>
                    <span class="info-value">#{{ $pasien->id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Umur:</span>
                    <span class="info-value">{{ $pasien->umur }} tahun</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Lahir:</span>
                    <span class="info-value">{{ $pasien->tanggal_lahir->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin:</span>
                    <span class="info-value">{{ $pasien->jenis_kelamin }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat:</span>
                    <span class="info-value">{{ $pasien->alamat }}</span>
                </div>
            </div>
        </div>
        
        <div class="info-section">
            <div class="info-title">STATISTIK PASIEN</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Total Pemberian Obat:</span>
                    <span class="info-value">{{ $totalPemberian }} kali</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Obat yang Pernah:</span>
                    <span class="info-value">{{ $pasien->pemberianObat->groupBy('obat_id')->count() }} jenis</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total Item Obat:</span>
                    <span class="info-value">{{ $pasien->pemberianObat->sum('jumlah') }} item</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Terdaftar Sejak:</span>
                    <span class="info-value">{{ $pasien->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
        
        @if($riwayatObat->count() > 0)
        <div class="info-section">
            <div class="info-title">RIWAYAT PEMBERIAN OBAT</div>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Aturan Pakai</th>
                        <th>Lama Penggunaan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatObat as $riwayat)
                    <tr>
                        <td>{{ $riwayat->tanggal_pemberian->format('d/m/Y') }}</td>
                        <td>{{ $riwayat->obat->nama_obat }}<br>
                            <small>{{ $riwayat->obat->kekuatan_dosis }}</small>
                        </td>
                        <td>{{ $riwayat->jumlah }} {{ $riwayat->obat->bentuk_sediaan }}</td>
                        <td>{{ $riwayat->berapa_kali_sehari }}x/hari<br>{{ $riwayat->sebelum_sesudah_makan }}</td>
                        <td>{{ $riwayat->lama_penggunaan_hari }} hari</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <div class="stamp">
            <div>
                <div class="sign-line">Pasien / Keluarga</div>
            </div>
            <div>
                <div class="sign-line">Petugas Farmasi</div>
            </div>
            <div>
                <div class="sign-line">Dokter</div>
            </div>
        </div>
        
        <div class="footer">
            <p>Dokumen ini adalah bukti sah dari Sistem Informasi Obat</p>
            <p>* Simpan dokumen ini sebagai arsip</p>
        </div>
    </div>
</body>
</html>