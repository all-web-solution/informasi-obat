@extends('layouts.print')

@section('title', 'Cetak Laporan Obat')
@section('print-title', 'Laporan Data Obat')
@section('print-subtitle', 'Master obat, stok, informasi edukasi, dan total pemberian')

@section('content')
<div class="print-summary-grid">
    <div class="print-summary-card">
        <div class="print-summary-label">Total Obat</div>
        <div class="print-summary-value">{{ $obats->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Stok Habis</div>
        <div class="print-summary-value">{{ $obats->where('stok', 0)->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Stok Menipis</div>
        <div class="print-summary-value">{{ $obats->where('stok', '>', 0)->where('stok', '<=', 10)->count() }}</div>
    </div>
    <div class="print-summary-card">
        <div class="print-summary-label">Total Pemberian</div>
        <div class="print-summary-value">{{ $obats->sum('pemberian_obat_count') }}</div>
    </div>
</div>

<table class="print-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Obat</th>
            <th>Sediaan</th>
            <th>Dosis</th>
            <th>Stok</th>
            <th>Indikasi</th>
            <th>Informasi Khusus</th>
            <th>Total Pemberian</th>
        </tr>
    </thead>
    <tbody>
        @foreach($obats as $index => $obat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $obat->nama_obat }}</strong></td>
                <td>{{ $obat->bentuk_sediaan }}</td>
                <td>{{ $obat->kekuatan_dosis }}</td>
                <td>{{ $obat->stok }}</td>
                <td>{{ $obat->informasiObat->indikasi_penyakit ?? '-' }}</td>
                <td>
                    @if($obat->informasiObat?->harus_dihabiskan)<span class="print-badge">Harus dihabiskan</span>@endif
                    @if($obat->informasiObat?->tidak_hentikan_mendadak)<span class="print-badge">Jangan hentikan mendadak</span>@endif
                    @if($obat->informasiObat?->penyimpanan_suhu === 'kulkas')<span class="print-badge">Simpan kulkas</span>@endif
                    @if($obat->informasiObat?->hindari_cahaya)<span class="print-badge">Hindari cahaya</span>@endif
                    @if($obat->informasiObat?->hindari_kelembaban)<span class="print-badge">Hindari lembab</span>@endif
                </td>
                <td>{{ $obat->pemberian_obat_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
