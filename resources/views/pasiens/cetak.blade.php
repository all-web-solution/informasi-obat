@extends('layouts.print')

@section('title', 'Cetak Detail Pasien')
@section('print-title', 'Detail Pasien')
@section('print-subtitle', 'Identitas pasien dan riwayat pemberian obat')

@section('content')
<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Nama Pasien</div>
        <div class="print-summary-value" style="font-size:16px;">{{ $pasien->nama }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Umur</div>
        <div class="print-summary-value">{{ $pasien->umur }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Jenis Kelamin</div>
        <div class="print-summary-value" style="font-size:16px;">{{ $pasien->jenis_kelamin }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Total Pemberian</div>
        <div class="print-summary-value">{{ $totalPemberian }}</div>
    </div>
</div>

<h3 class="print-section-title">Data Pasien</h3>
<table class="print-table">
    <tr>
        <th style="width: 220px;">Nama</th>
        <td>{{ $pasien->nama }}</td>
    </tr>
    <tr>
        <th>Tanggal Lahir</th>
        <td>{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
    </tr>
    <tr>
        <th>Jenis Kelamin</th>
        <td>{{ $pasien->jenis_kelamin }}</td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td>{{ $pasien->alamat }}</td>
    </tr>
</table>

<h3 class="print-section-title">Riwayat Pemberian Obat</h3>
<table class="print-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Obat dan Aturan Pakai</th>
            <th>Diagnosa/Keluhan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayatObat as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_pemberian ? \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') : '-' }}</td>
                <td style="white-space: pre-line;">{{ $item->obat_aturan_pakai }}</td>
                <td style="white-space: pre-line;">{{ $item->diagnosa_keluhan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Belum ada riwayat pemberian obat.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
