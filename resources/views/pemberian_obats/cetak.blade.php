@extends('layouts.print')

@section('title', 'Cetak Detail Pemberian Obat')
@section('print-title', 'Detail Pemberian Obat')
@section('print-subtitle', 'Informasi obat dan aturan pakai pasien')

@section('content')
<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Tanggal</div>
        <div class="print-summary-value" style="font-size:16px;">
            {{ $pemberianObat->tanggal_pemberian ? \Carbon\Carbon::parse($pemberianObat->tanggal_pemberian)->format('d/m/Y') : '-' }}
        </div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Pasien</div>
        <div class="print-summary-value" style="font-size:16px;">
            {{ $pemberianObat->pasien->nama ?? '-' }}
        </div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Jenis Kelamin</div>
        <div class="print-summary-value" style="font-size:16px;">
            {{ $pemberianObat->pasien->jenis_kelamin ?? '-' }}
        </div>
    </div>

    <div class="print-summary-card">
        <div class="print-summary-label">Umur</div>
        <div class="print-summary-value">
            {{ $pemberianObat->pasien->umur ?? '-' }}
        </div>
    </div>
</div>

<h3 class="print-section-title">Obat dan Aturan Pakai</h3>
<table class="print-table">
    <tr>
        <td style="white-space: pre-line;">{{ $pemberianObat->obat_aturan_pakai }}</td>
    </tr>
</table>

<h3 class="print-section-title">Diagnosa/Keluhan</h3>
<table class="print-table">
    <tr>
        <td style="white-space: pre-line;">{{ $pemberianObat->diagnosa_keluhan }}</td>
    </tr>
</table>

<h3 class="print-section-title">Informasi Tambahan</h3>
<table class="print-table">
    <tr>
        <td style="white-space: pre-line;">{{ $pemberianObat->informasi_tambahan ?: '-' }}</td>
    </tr>
</table>
@endsection
