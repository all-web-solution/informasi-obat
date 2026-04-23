<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resep Obat - {{ $pemberianObat->pasien->nama }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .resep-title {
            text-align: center;
            font-size: 24px;
            margin: 20px 0;
        }
        .info-pasien {
            margin-bottom: 30px;
        }
        .info-pasien table {
            width: 100%;
        }
        .info-pasien td {
            padding: 5px;
        }
        .obat-info {
            margin: 30px 0;
            border: 1px solid #ddd;
            padding: 15px;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        @media print {
            .btn-print {
                display: none;
            }
        }
        .btn-print {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    
    <div class="header">
        <h2>KLINIK SEHAT SEJAHTERA</h2>
        <p>Jl. Kesehatan No. 123, Telp. (021) 1234567</p>
        <p>Resep Obat</p>
    </div>
    
    <div class="resep-title">
        <strong>RESEP OBAT</strong>
    </div>
    
    <div class="info-pasien">
        <table>
            <tr><td width="120">Nama Pasien</td><td>: <strong>{{ $pemberianObat->pasien->nama }}</strong></td></tr>
            <tr><td>Umur</td><td>: {{ $pemberianObat->pasien->umur }} tahun</td></tr>
            <tr><td>Jenis Kelamin</td><td>: {{ $pemberianObat->pasien->jenis_kelamin }}</td></tr>
            <tr><td>Tanggal</td><td>: {{ date('d/m/Y', strtotime($pemberianObat->tanggal_pemberian)) }}</td></tr>
        </table>
    </div>
    
    <div class="obat-info">
        <h4>Diagnosa / Keluhan:</h4>
        <p>{{ $pemberianObat->diagnosa_keluhan }}</p>
        
        <h4>Nama Obat:</h4>
        <p><strong>{{ $pemberianObat->obat }}</strong></p>
        
        <h4>Aturan Pakai:</h4>
        <ul>
            <li>{{ $pemberianObat->berapa_kali_sehari }} kali sehari</li>
            <li>{{ ucfirst($pemberianObat->sebelum_sesudah_makan) }}</li>
            <li>Lama penggunaan: {{ $pemberianObat->lama_penggunaan_hari }} hari</li>
        </ul>
        
        @if($pemberianObat->informasi_tambahan)
        <h4>Informasi Tambahan:</h4>
        <p>{{ $pemberianObat->informasi_tambahan }}</p>
        @endif
    </div>
    
    <div class="footer">
        <p>Dokter,</p>
        <br><br>
        <p>(_________________)</p>
        <p>STR: 12345/XX/YYYY</p>
    </div>
</body>
</html>