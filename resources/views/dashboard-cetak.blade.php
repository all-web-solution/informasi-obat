@extends('layouts.print')

@section('title', 'Cetak Dashboard')
@section('print-title', 'Dashboard Apotek Singkut Farma')
@section('print-subtitle', 'Ringkasan pasien, obat, stok, dan pemberian obat')

@section('content')
<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Total Pasien</div>
        <div class="print-summary-value">{{ $summary['total_pasien'] }}</div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Total Master Obat</div>
        <div class="print-summary-value">{{ $summary['total_obat'] }}</div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Total Pemberian</div>
        <div class="print-summary-value">{{ $summary['total_pemberian'] }}</div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Pemberian Bulan Ini</div>
        <div class="print-summary-value">{{ $summary['pemberian_bulan_ini'] }}</div>
    </div>
</div>

<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Stok Menipis</div>
        <div class="print-summary-value">{{ $summary['stok_menipis'] }}</div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Stok Habis</div>
        <div class="print-summary-value">{{ $summary['stok_habis'] }}</div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Filter Aktif</div>
        <div class="print-summary-value" style="font-size:15px;">
            {{ $searchNama ?: '-' }}
        </div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Data Ditampilkan</div>
        <div class="print-summary-value">{{ $pemberianTerbaru->count() }}</div>
    </div>
</div>

<h3 class="print-section-title">Pemberian Obat Terbaru</h3>
<table class="print-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pasien</th>
            <th>Obat dan Aturan Pakai</th>
            <th>Diagnosa/Keluhan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pemberianTerbaru as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_pemberian ? \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') : '-' }}</td>
                <td>
                    <strong>{{ $item->pasien->nama ?? '-' }}</strong><br>
                    <small>{{ $item->pasien->jenis_kelamin ?? '-' }} | {{ $item->pasien->umur ?? '-' }} tahun</small>
                </td>
                <td style="white-space: pre-line;">{{ $item->obat_aturan_pakai }}</td>
                <td style="white-space: pre-line;">{{ $item->diagnosa_keluhan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada data pemberian obat.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<h3 class="print-section-title">Stok Kritis</h3>
<table class="print-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Sediaan</th>
            <th>Dosis</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stokKritis as $index => $obat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $obat->nama_obat }}</td>
                <td>{{ $obat->bentuk_sediaan }}</td>
                <td>{{ $obat->kekuatan_dosis }}</td>
                <td>{{ $obat->stok }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Tidak ada stok kritis.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
