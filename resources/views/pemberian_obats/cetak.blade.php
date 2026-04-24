@extends('layouts.print')

@section('title', 'Cetak Detail Pemberian Obat')
@section('print-title', 'Detail Pemberian Obat')
@section('print-subtitle', 'Informasi obat dan edukasi pasien')

@section('content')
@php
    $info = $pemberianObat->informasiLengkap();
@endphp

<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Tanggal</div>
        <div class="print-summary-value" style="font-size:16px;">
            {{ $pemberianObat->tanggal_pemberian ? \Carbon\Carbon::parse($pemberianObat->tanggal_pemberian)->format('d/m/Y') : '-' }}
        </div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Pasien</div>
        <div class="print-summary-value" style="font-size:16px;">{{ $pemberianObat->pasien->nama ?? '-' }}</div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Obat</div>
        <div class="print-summary-value" style="font-size:16px;">{{ $pemberianObat->nama_obat_display }}</div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Jumlah</div>
        <div class="print-summary-value">{{ $pemberianObat->jumlah }}</div>
    </div>
</div>

<h3 class="print-section-title">Informasi Pemberian</h3>
<table class="print-table">
    <tr>
        <th style="width: 220px;">Aturan Pakai</th>
        <td>{{ $pemberianObat->aturan_pakai_display }}</td>
    </tr>
    <tr>
        <th>Diagnosa/Keluhan</th>
        <td>{{ $pemberianObat->diagnosa_keluhan }}</td>
    </tr>
    <tr>
        <th>Informasi Tambahan</th>
        <td>{{ $pemberianObat->informasi_tambahan ?: '-' }}</td>
    </tr>
</table>

<h3 class="print-section-title">Edukasi Obat</h3>
<table class="print-table">
    <tr>
        <th style="width: 220px;">Indikasi</th>
        <td>{{ $info->indikasi }}</td>
    </tr>
    <tr>
        <th>Efek Samping Umum</th>
        <td>{{ $info->efek_samping }}</td>
    </tr>
    <tr>
        <th>Tanda Bahaya</th>
        <td>{{ $info->tanda_bahaya }}</td>
    </tr>
    <tr>
        <th>Interaksi Obat</th>
        <td>{{ $info->interaksi_obat }}</td>
    </tr>
    <tr>
        <th>Interaksi Makanan</th>
        <td>{{ $info->interaksi_makanan }}</td>
    </tr>
    <tr>
        <th>Penyimpanan</th>
        <td>{{ $info->penyimpanan }}</td>
    </tr>
    <tr>
        <th>Hal Khusus</th>
        <td>
            @forelse($info->hal_khusus as $item)
                <span class="print-badge">{{ $item }}</span>
            @empty
                -
            @endforelse
        </td>
    </tr>
</table>
@endsection
