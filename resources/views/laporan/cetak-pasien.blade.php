@extends('layouts.print')

@section('title', 'Cetak Laporan Pasien')
@section('print-title', 'Laporan Data Pasien')
@section('print-subtitle', 'Daftar pasien dan jumlah riwayat pemberian obat')

@section('content')
<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Total Pasien</div>
        <div class="print-summary-value">{{ $pasiens->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Laki-laki</div>
        <div class="print-summary-value">{{ $pasiens->where('jenis_kelamin', 'Laki-laki')->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Perempuan</div>
        <div class="print-summary-value">{{ $pasiens->where('jenis_kelamin', 'Perempuan')->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Total Pemberian</div>
        <div class="print-summary-value">{{ $pasiens->sum('pemberian_obat_count') }}</div>
    </div>
</div>

<table class="print-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Umur</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Total Pemberian Obat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pasiens as $index => $pasien)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pasien->nama }}</td>
                <td>{{ $pasien->umur }} tahun</td>
                <td>{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                <td>{{ $pasien->jenis_kelamin }}</td>
                <td>{{ $pasien->alamat }}</td>
                <td>{{ $pasien->pemberian_obat_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
