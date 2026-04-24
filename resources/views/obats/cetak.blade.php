@extends('layouts.print')

@section('title', 'Cetak Detail Obat')
@section('print-title', 'Detail Obat')
@section('print-subtitle', 'Informasi master obat dan edukasi penggunaan')

@section('content')
<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Nama Obat</div>
        <div class="print-summary-value" style="font-size:16px;">{{ $obat->nama_obat }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Bentuk</div>
        <div class="print-summary-value" style="font-size:16px;">{{ $obat->bentuk_sediaan }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Dosis</div>
        <div class="print-summary-value" style="font-size:16px;">{{ $obat->kekuatan_dosis }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Stok</div>
        <div class="print-summary-value">{{ $obat->stok }}</div>
    </div>
</div>

<h3 class="print-section-title">Informasi Obat</h3>
<table class="print-table">
    <tr>
        <th style="width: 220px;">Indikasi</th>
        <td>{{ $obat->informasiObat->indikasi_penyakit ?? '-' }}</td>
    </tr>
    <tr>
        <th>Efek Samping Umum</th>
        <td>{{ $obat->informasiObat->efek_samping_umum ?? '-' }}</td>
    </tr>
    <tr>
        <th>Tanda Bahaya</th>
        <td>{{ $obat->informasiObat->tanda_bahaya ?? '-' }}</td>
    </tr>
    <tr>
        <th>Interaksi Obat</th>
        <td>{{ $obat->informasiObat->interaksi_obat ?? '-' }}</td>
    </tr>
    <tr>
        <th>Interaksi Makanan</th>
        <td>{{ $obat->informasiObat->interaksi_makanan ?? '-' }}</td>
    </tr>
    <tr>
        <th>Penyimpanan</th>
        <td>
            {{ $obat->informasiObat->penyimpanan_suhu ?? '-' }}
            @if($obat->informasiObat?->hindari_cahaya)
                <span class="print-badge">Hindari cahaya</span>
            @endif
            @if($obat->informasiObat?->hindari_kelembaban)
                <span class="print-badge">Hindari lembab</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Hal Khusus</th>
        <td>
            @if($obat->informasiObat?->harus_dihabiskan)
                <span class="print-badge">Harus dihabiskan</span>
            @endif
            @if($obat->informasiObat?->tidak_hentikan_mendadak)
                <span class="print-badge">Jangan hentikan mendadak</span>
            @endif
            {{ $obat->informasiObat->cara_penggunaan_khusus ?? '' }}
        </td>
    </tr>
</table>
@endsection
