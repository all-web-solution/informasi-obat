@extends('layouts.app')

@section('title', 'Detail Pemberian Obat')
@section('page-title', 'Detail Pemberian Obat')
@section('page-description', 'Informasi detail pemberian obat dan edukasi pasien')

@section('content')
@php
    $info = $pemberianObat->informasiLengkap();
@endphp

<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Detail Pemberian Obat</h1>
            <p class="native-card-subtitle">Detail pasien, obat, aturan pakai, dan informasi edukasi.</p>
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
            <div class="native-detail-value">{{ \Carbon\Carbon::parse($pemberianObat->tanggal_pemberian)->format('d/m/Y') }}</div>
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

        <div class="native-detail-item">
            <div class="native-detail-label">Obat</div>
            <div class="native-detail-value">
                <div class="medicine-card-inline">
                    <div class="medicine-icon"><i class="fas fa-capsules"></i></div>
                    <div>
                        <div class="medicine-name">{{ $pemberianObat->nama_obat_display }}</div>
                        <div class="medicine-meta">{{ $pemberianObat->detail_obat_display }}</div>
                        <div class="medicine-badges">
                            <span class="medicine-badge">{{ $pemberianObat->jumlah }} unit diberikan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Aturan Pakai</div>
            <div class="native-detail-value">{{ $pemberianObat->aturan_pakai_display }}</div>
        </div>

        <div class="native-detail-item" style="grid-column: 1 / -1;">
            <div class="native-detail-label">Diagnosa/Keluhan</div>
            <div class="native-detail-value">{{ $pemberianObat->diagnosa_keluhan }}</div>
        </div>

        <div class="native-detail-item" style="grid-column: 1 / -1;">
            <div class="native-detail-label">Informasi Tambahan</div>
            <div class="native-detail-value">{{ $pemberianObat->informasi_tambahan ?: '-' }}</div>
        </div>
    </div>
</div>

<div class="native-card">
    <div class="native-card-header">
        <div>
            <h2 class="native-card-title">Informasi Edukasi Obat</h2>
            <p class="native-card-subtitle">Informasi ini ditampilkan berdasarkan master informasi obat.</p>
        </div>
    </div>

    <div class="native-detail-grid">
        <div class="native-detail-item">
            <div class="native-detail-label">Indikasi</div>
            <div class="native-detail-value">{{ $info->indikasi }}</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Efek Samping Umum</div>
            <div class="native-detail-value">{{ $info->efek_samping }}</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Tanda Bahaya</div>
            <div class="native-detail-value">{{ $info->tanda_bahaya }}</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Penyimpanan</div>
            <div class="native-detail-value">{{ $info->penyimpanan }}</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Interaksi Obat</div>
            <div class="native-detail-value">{{ $info->interaksi_obat }}</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Interaksi Makanan</div>
            <div class="native-detail-value">{{ $info->interaksi_makanan }}</div>
        </div>

        <div class="native-detail-item" style="grid-column: 1 / -1;">
            <div class="native-detail-label">Hal Khusus</div>
            <div class="native-detail-value">
                @forelse($info->hal_khusus as $item)
                    <span class="native-badge">{{ $item }}</span>
                @empty
                    -
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
