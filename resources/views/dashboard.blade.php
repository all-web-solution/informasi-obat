@extends('layouts.app')

@section('title', 'Dashboard - Sistem Informasi Obat')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan data pasien, obat, stok, dan pemberian obat')

@section('content')
<div class="dashboard-hero">
    <div class="dashboard-hero-content">
        <div>
            <h1>Dashboard Sistem Informasi Obat</h1>
            <p>
                Pantau data pasien, master obat, stok kritis, dan riwayat pemberian obat terbaru
                dalam satu halaman ringkas.
            </p>
        </div>

        <div class="dashboard-hero-actions no-print">
            <a href="{{ route('pemberian_obats.create') }}" class="native-btn dashboard-btn-light">
                <i class="fas fa-plus"></i> Tambah Pemberian
            </a>
            <a href="{{ route('cetak.dashboard', request()->query()) }}" target="_blank" class="native-btn dashboard-btn-outline">
                <i class="fas fa-print"></i> Cetak Dashboard
            </a>
        </div>
    </div>
</div>

<div class="dashboard-stat-grid">
    <div class="dashboard-stat-card">
        <div class="dashboard-stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="dashboard-stat-label">Total Pasien</div>
            <div class="dashboard-stat-value">{{ number_format($totalPasien) }}</div>
            <a href="{{ route('pasiens.index') }}" class="dashboard-stat-link">Lihat data pasien</a>
        </div>
    </div>

    <div class="dashboard-stat-card">
        <div class="dashboard-stat-icon">
            <i class="fas fa-capsules"></i>
        </div>
        <div>
            <div class="dashboard-stat-label">Total Master Obat</div>
            <div class="dashboard-stat-value">{{ number_format($totalObat) }}</div>
            <a href="{{ route('obats.index') }}" class="dashboard-stat-link">Lihat data obat</a>
        </div>
    </div>

    <div class="dashboard-stat-card">
        <div class="dashboard-stat-icon">
            <i class="fas fa-prescription"></i>
        </div>
        <div>
            <div class="dashboard-stat-label">Total Pemberian</div>
            <div class="dashboard-stat-value">{{ number_format($totalPemberian) }}</div>
            <a href="{{ route('pemberian_obats.index') }}" class="dashboard-stat-link">Lihat pemberian</a>
        </div>
    </div>

    <div class="dashboard-stat-card">
        <div class="dashboard-stat-icon dashboard-warning">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <div class="dashboard-stat-label">Stok Menipis</div>
            <div class="dashboard-stat-value">{{ number_format($stokMenipis) }}</div>
            <a href="{{ route('obats.index', ['filter_stok' => 'menipis']) }}" class="dashboard-stat-link">Cek stok</a>
        </div>
    </div>
</div>

<div class="dashboard-stat-grid dashboard-stat-grid-small">
    <div class="dashboard-mini-card">
        <div class="dashboard-mini-label">Stok Habis</div>
        <div class="dashboard-mini-value danger">{{ number_format($stokHabis) }}</div>
    </div>

    <div class="dashboard-mini-card">
        <div class="dashboard-mini-label">Pemberian Bulan Ini</div>
        <div class="dashboard-mini-value">{{ number_format($pemberianBulanIni) }}</div>
    </div>

    <div class="dashboard-mini-card">
        <div class="dashboard-mini-label">Data Terbaru Ditampilkan</div>
        <div class="dashboard-mini-value">{{ $pemberianTerbaru->count() }}</div>
    </div>

    <div class="dashboard-mini-card">
        <div class="dashboard-mini-label">Tanggal Hari Ini</div>
        <div class="dashboard-mini-value date">{{ now()->format('d/m/Y') }}</div>
    </div>
</div>

<div class="native-card no-print">
    <div class="native-card-header">
        <div>
            <h2 class="native-card-title">Cari Pemberian Obat</h2>
            <p class="native-card-subtitle">
                Cari berdasarkan nama pasien, obat dan aturan pakai, atau diagnosa/keluhan.
            </p>
        </div>
    </div>

    <form method="GET" action="{{ route('dashboard') }}">
        <div class="dashboard-search-row">
            <div class="native-form-group">
                <label>Kata Kunci</label>
                <input
                    type="text"
                    name="search_nama"
                    value="{{ $searchNama }}"
                    placeholder="Contoh: Budi, Paracetamol, demam..."
                >
            </div>

            <div class="native-actions dashboard-search-actions">
                <a href="{{ route('dashboard') }}" class="native-btn native-btn-secondary">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="native-btn native-btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>
    </form>
</div>

<div class="dashboard-grid-2">
    <div class="native-card">
        <div class="native-card-header">
            <div>
                <h2 class="native-card-title">Pemberian Obat Terbaru</h2>
                <p class="native-card-subtitle">5 data terbaru berdasarkan tanggal pemberian.</p>
            </div>
            <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary no-print">
                Lihat Semua
            </a>
        </div>

        <div class="dashboard-list">
            @forelse($pemberianTerbaru as $item)
                <a href="{{ route('pemberian_obats.show', $item) }}" class="dashboard-list-item">
                    <div class="dashboard-list-icon">
                        <i class="fas fa-prescription-bottle-medical"></i>
                    </div>

                    <div class="dashboard-list-body">
                        <div class="dashboard-list-title">
                            {{ $item->pasien->nama ?? '-' }}
                        </div>
                        <div class="dashboard-list-meta">
                            {{ $item->tanggal_pemberian ? \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') : '-' }}
                            • {{ $item->pasien->jenis_kelamin ?? '-' }}
                            • {{ $item->pasien->umur ?? '-' }} tahun
                        </div>
                        <div class="dashboard-list-text">
                            {{ $item->ringkasan_obat }}
                        </div>
                    </div>

                    <div class="dashboard-list-arrow no-print">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            @empty
                <div class="dashboard-empty">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada data pemberian obat.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="native-card">
        <div class="native-card-header">
            <div>
                <h2 class="native-card-title">Stok Kritis</h2>
                <p class="native-card-subtitle">Obat dengan stok 10 atau kurang.</p>
            </div>
            <a href="{{ route('obats.index', ['filter_stok' => 'menipis']) }}" class="native-btn native-btn-secondary no-print">
                Lihat Obat
            </a>
        </div>

        <div class="dashboard-stock-list">
            @forelse($stokKritis as $obat)
                <div class="dashboard-stock-item">
                    <div>
                        <div class="dashboard-stock-name">{{ $obat->nama_obat }}</div>
                        <div class="dashboard-stock-meta">
                            {{ $obat->kekuatan_dosis }} • {{ $obat->bentuk_sediaan }}
                        </div>
                    </div>

                    <span class="dashboard-stock-badge {{ $obat->stok == 0 ? 'danger' : 'warning' }}">
                        {{ $obat->stok }}
                    </span>
                </div>
            @empty
                <div class="dashboard-empty">
                    <i class="fas fa-check-circle"></i>
                    <p>Tidak ada stok kritis.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="dashboard-grid-2">
    <div class="native-card">
        <div class="native-card-header">
            <div>
                <h2 class="native-card-title">Top Pasien</h2>
                <p class="native-card-subtitle">Pasien dengan frekuensi pemberian obat terbanyak.</p>
            </div>
        </div>

        @forelse($topPasien as $item)
            @php
                $max = max($topPasien->max('total_pemberian'), 1);
                $percent = min(100, ($item->total_pemberian / $max) * 100);
            @endphp

            <div class="dashboard-progress-item">
                <div class="dashboard-progress-header">
                    <div>
                        <strong>{{ $item->pasien->nama ?? '-' }}</strong>
                        <span>{{ $item->pasien->jenis_kelamin ?? '-' }} • {{ $item->pasien->umur ?? '-' }} tahun</span>
                    </div>
                    <span class="native-badge">{{ $item->total_pemberian }}x</span>
                </div>
                <div class="dashboard-progress">
                    <div class="dashboard-progress-bar" style="width: {{ $percent }}%;"></div>
                </div>
            </div>
        @empty
            <div class="dashboard-empty">
                <i class="fas fa-chart-simple"></i>
                <p>Belum ada data untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <div class="native-card">
        <div class="native-card-header">
            <div>
                <h2 class="native-card-title">Pasien Terbaru</h2>
                <p class="native-card-subtitle">5 pasien yang terakhir ditambahkan.</p>
            </div>
            <a href="{{ route('pasiens.index') }}" class="native-btn native-btn-secondary no-print">
                Lihat Semua
            </a>
        </div>

        <div class="dashboard-patient-grid">
            @forelse($pasienTerbaru as $pasien)
                <a href="{{ route('pasiens.show', $pasien) }}" class="dashboard-patient-card">
                    <div class="dashboard-patient-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>{{ $pasien->nama }}</strong>
                        <span>{{ $pasien->jenis_kelamin }} • {{ $pasien->umur }} tahun</span>
                    </div>
                </a>
            @empty
                <div class="dashboard-empty">
                    <i class="fas fa-users"></i>
                    <p>Belum ada data pasien.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
