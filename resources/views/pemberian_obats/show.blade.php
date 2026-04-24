@extends('layouts.app')

@section('title', 'Detail Pemberian Obat')
@section('page-title', 'Detail Pemberian Obat')
@section('page-description', 'Informasi detail pemberian obat dan edukasi pasien')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Detail Pemberian Obat</h1>
            <p class="native-card-subtitle">
                Detail pasien, obat dan aturan pakai, diagnosa, serta informasi tambahan.
            </p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary">Kembali</a>
            <a href="{{ route('pemberian_obats.edit', $pemberianObat) }}" class="native-btn native-btn-primary">Edit</a>
            <a href="{{ route('pemberian_obats.cetak', $pemberianObat) }}" target="_blank" class="native-btn native-btn-success">Cetak</a>
        </div>
    </div>

    <div class="native-detail-grid">
        <div class="native-detail-item">
            <div class="native-detail-label">Tanggal Pemberian</div>
            <div class="native-detail-value">
                {{ \Carbon\Carbon::parse($pemberianObat->tanggal_pemberian)->format('d/m/Y') }}
            </div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Pasien</div>
            <div class="native-detail-value">
                {{ $pemberianObat->pasien->nama ?? '-' }}
                <div class="medicine-meta">
                    {{ $pemberianObat->pasien->jenis_kelamin ?? '-' }} | {{ $pemberianObat->pasien->umur ?? '-' }} tahun
                </div>
            </div>
        </div>

        <div class="native-detail-item" style="grid-column: 1 / -1;">
            <div class="native-detail-label">Obat dan Aturan Pakai</div>
            <div class="native-detail-value" style="white-space: pre-line;">
                {{ $pemberianObat->obat_aturan_pakai }}
            </div>
        </div>

        <div class="native-detail-item" style="grid-column: 1 / -1;">
            <div class="native-detail-label">Diagnosa/Keluhan</div>
            <div class="native-detail-value" style="white-space: pre-line;">
                {{ $pemberianObat->diagnosa_keluhan }}
            </div>
        </div>

        <div class="native-detail-item" style="grid-column: 1 / -1;">
            <div class="native-detail-label">Informasi Tambahan</div>
            <div class="native-detail-value" style="white-space: pre-line;">
                {{ $pemberianObat->informasi_tambahan ?: '-' }}
            </div>
        </div>
    </div>
</div>
@endsection
