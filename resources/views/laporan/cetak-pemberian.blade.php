@extends('layouts.print')

@section('title', 'Cetak Laporan Pemberian Obat')
@section('print-title', 'Laporan Pemberian Obat')
@section('print-subtitle', 'Riwayat pemberian obat kepada pasien')

@section('content')
<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Total Data</div>
        <div class="print-summary-value">{{ $pemberianObats->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Total Pasien Unik</div>
        <div class="print-summary-value">{{ $pemberianObats->pluck('pasien_id')->unique()->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Tanggal Awal</div>
        <div class="print-summary-value" style="font-size:15px;">
            {{ $filters['tanggal_awal'] ? \Carbon\Carbon::parse($filters['tanggal_awal'])->format('d/m/Y') : 'Semua' }}
        </div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Tanggal Akhir</div>
        <div class="print-summary-value" style="font-size:15px;">
            {{ $filters['tanggal_akhir'] ? \Carbon\Carbon::parse($filters['tanggal_akhir'])->format('d/m/Y') : 'Semua' }}
        </div>
    </div>
</div>

<table class="print-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pasien</th>
            <th>Obat dan Aturan Pakai</th>
            <th>Diagnosa/Keluhan</th>
            <th>Info Tambahan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pemberianObats as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_pemberian ? \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') : '-' }}</td>
                <td>
                    <strong>{{ $item->pasien->nama ?? '-' }}</strong><br>
                    <small>{{ $item->pasien->jenis_kelamin ?? '-' }} | {{ $item->pasien->umur ?? '-' }} tahun</small>
                </td>
                <td style="white-space: pre-line;">{{ $item->obat_aturan_pakai }}</td>
                <td style="white-space: pre-line;">{{ $item->diagnosa_keluhan }}</td>
                <td style="white-space: pre-line;">{{ $item->informasi_tambahan ?: '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada data pemberian obat pada periode ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
