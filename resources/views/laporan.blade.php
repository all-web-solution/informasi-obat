@extends('layouts.app')

@section('title', 'Laporan - Sistem Informasi Obat')
@section('page-title', 'Laporan')
@section('page-description', 'Analisis data pasien, obat, stok, dan pemberian obat')

@section('content')
<div class="print-header">
    <h2>Laporan Sistem Informasi Obat</h2>
    <p>Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="report-hero">
    <div class="report-hero-content">
        <h1><i class="fas fa-chart-line me-2"></i> Laporan Sistem Informasi Obat</h1>
        <p>
            Ringkasan analitik untuk memantau data pasien, master obat, stok obat,
            riwayat pemberian obat, dan item yang membutuhkan perhatian khusus.
        </p>
    </div>
</div>

<div class="native-card report-filter-card no-print">
    <div class="native-card-header">
        <div>
            <h2 class="native-card-title">Filter Laporan</h2>
            <p class="native-card-subtitle">Gunakan rentang tanggal untuk menganalisis data pemberian obat.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('laporan') }}">
        <div class="report-filter-grid">
            <div class="native-form-group">
                <label>Tanggal Awal</label>
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
            </div>

            <div class="native-form-group">
                <label>Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
            </div>

            <div class="native-actions">
                <a href="{{ route('laporan') }}" class="native-btn native-btn-secondary">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="native-btn native-btn-primary">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
            </div>

            <div class="native-actions">
                <a href="{{ route('cetak.pasien', request()->query()) }}" target="_blank" class="native-btn native-btn-info">
                    <i class="fas fa-print"></i> Cetak Pasien
                </a>
                <a href="{{ route('cetak.obat', request()->query()) }}" target="_blank" class="native-btn native-btn-success">
                    <i class="fas fa-print"></i> Cetak Obat
                </a>
            </div>

            <div class="native-actions">
                <a href="{{ route('cetak.pemberian', request()->query()) }}" target="_blank" class="native-btn native-btn-warning">
                    <i class="fas fa-print"></i> Cetak Pemberian
                </a>
                <button type="button" onclick="window.print()" class="native-btn native-btn-secondary">
                    <i class="fas fa-file-lines"></i> Cetak Ringkasan
                </button>
            </div>
        </div>
    </form>
</div>

<div class="report-stat-grid">
    <div class="report-stat-card">
        <div class="report-stat-icon"><i class="fas fa-users"></i></div>
        <div>
            <div class="report-stat-label">Total Pasien</div>
            <div class="report-stat-value">{{ number_format($summary['total_pasien']) }}</div>
        </div>
    </div>

    <div class="report-stat-card">
        <div class="report-stat-icon"><i class="fas fa-capsules"></i></div>
        <div>
            <div class="report-stat-label">Total Obat</div>
            <div class="report-stat-value">{{ number_format($summary['total_obat']) }}</div>
        </div>
    </div>

    <div class="report-stat-card">
        <div class="report-stat-icon"><i class="fas fa-prescription"></i></div>
        <div>
            <div class="report-stat-label">Pemberian Obat</div>
            <div class="report-stat-value">{{ number_format($summary['total_pemberian']) }}</div>
        </div>
    </div>

    <div class="report-stat-card">
        <div class="report-stat-icon"><i class="fas fa-boxes-stacked"></i></div>
        <div>
            <div class="report-stat-label">Jumlah Obat Diberikan</div>
            <div class="report-stat-value">{{ number_format($summary['total_jumlah_obat_diberikan']) }}</div>
        </div>
    </div>
</div>

<div class="report-stat-grid">
    <div class="report-stat-card">
        <div class="report-stat-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-triangle-exclamation"></i></div>
        <div>
            <div class="report-stat-label">Stok Menipis</div>
            <div class="report-stat-value">{{ number_format($summary['stok_menipis']) }}</div>
        </div>
    </div>

    <div class="report-stat-card">
        <div class="report-stat-icon" style="background:#fee2e2;color:#dc2626;"><i class="fas fa-circle-xmark"></i></div>
        <div>
            <div class="report-stat-label">Stok Habis</div>
            <div class="report-stat-value">{{ number_format($summary['stok_habis']) }}</div>
        </div>
    </div>

    <div class="report-stat-card">
        <div class="report-stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="fas fa-mars"></i></div>
        <div>
            <div class="report-stat-label">Pasien Laki-laki</div>
            <div class="report-stat-value">{{ number_format($komposisiPasien['laki_laki']) }}</div>
        </div>
    </div>

    <div class="report-stat-card">
        <div class="report-stat-icon" style="background:#fce7f3;color:#db2777;"><i class="fas fa-venus"></i></div>
        <div>
            <div class="report-stat-label">Pasien Perempuan</div>
            <div class="report-stat-value">{{ number_format($komposisiPasien['perempuan']) }}</div>
        </div>
    </div>
</div>

<div class="report-grid-2">
    <div class="native-card">
        <div class="native-card-header">
            <div>
                <h2 class="native-card-title">Top 5 Obat Paling Sering Diberikan</h2>
                <p class="native-card-subtitle">Berdasarkan jumlah transaksi pemberian obat.</p>
            </div>
        </div>

        @forelse($topObats as $item)
            @php
                $max = max($topObats->max('total_pemberian'), 1);
                $percent = min(100, ($item->total_pemberian / $max) * 100);
            @endphp
            <div style="margin-bottom:16px;">
                <div class="d-flex justify-content-between gap-3 mb-2">
                    <div>
                        <strong>{{ $item->obat->nama_obat ?? '-' }}</strong><br>
                        <small class="text-muted">{{ $item->obat->kekuatan_dosis ?? '-' }} | {{ $item->obat->bentuk_sediaan ?? '-' }}</small>
                    </div>
                    <div class="text-end">
                        <span class="native-badge">{{ $item->total_pemberian }}x</span><br>
                        <small class="text-muted">{{ $item->total_jumlah }} unit</small>
                    </div>
                </div>
                <div class="report-progress">
                    <div class="report-progress-bar" style="width: {{ $percent }}%;"></div>
                </div>
            </div>
        @empty
            <div class="report-empty">Belum ada data pemberian obat.</div>
        @endforelse
    </div>

    <div class="native-card">
        <div class="native-card-header">
            <div>
                <h2 class="native-card-title">Top 5 Pasien Berdasarkan Pemberian Obat</h2>
                <p class="native-card-subtitle">Pasien dengan frekuensi pemberian obat terbanyak.</p>
            </div>
        </div>

        @forelse($topPasiens as $item)
            @php
                $max = max($topPasiens->max('total_pemberian'), 1);
                $percent = min(100, ($item->total_pemberian / $max) * 100);
            @endphp
            <div style="margin-bottom:16px;">
                <div class="d-flex justify-content-between gap-3 mb-2">
                    <div>
                        <strong>{{ $item->pasien->nama ?? '-' }}</strong><br>
                        <small class="text-muted">{{ $item->pasien->jenis_kelamin ?? '-' }} | {{ $item->pasien->umur ?? '-' }} tahun</small>
                    </div>
                    <span class="native-badge">{{ $item->total_pemberian }}x</span>
                </div>
                <div class="report-progress">
                    <div class="report-progress-bar" style="width: {{ $percent }}%;"></div>
                </div>
            </div>
        @empty
            <div class="report-empty">Belum ada data pemberian obat.</div>
        @endforelse
    </div>
</div>

<div class="report-grid-2">
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

        <div class="native-table-wrapper">
            <table class="native-table">
                <thead>
                    <tr>
                        <th>Obat</th>
                        <th>Sediaan</th>
                        <th>Stok</th>
                        <th>Penyimpanan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stokKritis as $obat)
                        <tr>
                            <td>
                                <strong>{{ $obat->nama_obat }}</strong><br>
                                <small>{{ $obat->kekuatan_dosis }}</small>
                            </td>
                            <td>{{ $obat->bentuk_sediaan }}</td>
                            <td>
                                <span class="native-badge" style="background:{{ $obat->stok == 0 ? '#fee2e2' : '#fef3c7' }};color:{{ $obat->stok == 0 ? '#dc2626' : '#d97706' }};">
                                    {{ $obat->stok }}
                                </span>
                            </td>
                            <td>{{ $obat->informasiObat->penyimpanan_suhu ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada stok kritis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="native-card">
        <div class="native-card-header">
            <div>
                <h2 class="native-card-title">Obat Perlu Perhatian Khusus</h2>
                <p class="native-card-subtitle">Berdasarkan aturan penyimpanan dan edukasi obat.</p>
            </div>
        </div>

        <div class="native-table-wrapper">
            <table class="native-table">
                <thead>
                    <tr>
                        <th>Obat</th>
                        <th>Informasi Penting</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($obatPerluPerhatian as $obat)
                        <tr>
                            <td>
                                <strong>{{ $obat->nama_obat }}</strong><br>
                                <small>{{ $obat->kekuatan_dosis }} | {{ $obat->bentuk_sediaan }}</small>
                            </td>
                            <td>
                                @if($obat->informasiObat?->harus_dihabiskan)
                                    <span class="native-badge">Harus dihabiskan</span>
                                @endif
                                @if($obat->informasiObat?->tidak_hentikan_mendadak)
                                    <span class="native-badge">Jangan hentikan mendadak</span>
                                @endif
                                @if($obat->informasiObat?->penyimpanan_suhu === 'kulkas')
                                    <span class="native-badge">Simpan kulkas</span>
                                @endif
                                @if($obat->informasiObat?->hindari_cahaya)
                                    <span class="native-badge">Hindari cahaya</span>
                                @endif
                                @if($obat->informasiObat?->hindari_kelembaban)
                                    <span class="native-badge">Hindari lembab</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Belum ada obat dengan perhatian khusus.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="native-card">
    <div class="native-card-header">
        <div>
            <h2 class="native-card-title">Riwayat Pemberian Obat Terbaru</h2>
            <p class="native-card-subtitle">10 data terbaru sesuai filter tanggal aktif.</p>
        </div>
        <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary no-print">
            Lihat Semua
        </a>
    </div>

    <div class="native-table-wrapper">
        <table class="native-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Obat</th>
                    <th>Aturan Pakai</th>
                    <th>Diagnosa/Keluhan</th>
                    <th class="no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestPemberian as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $item->pasien->nama ?? '-' }}</strong><br>
                            <small>{{ $item->pasien->jenis_kelamin ?? '-' }} | {{ $item->pasien->umur ?? '-' }} tahun</small>
                        </td>
                        <td>
                            <strong>{{ $item->obat->nama_obat ?? '-' }}</strong><br>
                            <small>{{ $item->obat->kekuatan_dosis ?? '-' }} | {{ $item->obat->bentuk_sediaan ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $item->jumlah }} unit<br>
                            <small>{{ $item->berapa_kali_sehari }}x sehari, {{ $item->sebelum_sesudah_makan }}, {{ $item->lama_penggunaan_hari }} hari</small>
                        </td>
                        <td>{{ $item->diagnosa_keluhan }}</td>
                        <td class="no-print">
                            <a href="{{ route('pemberian_obats.show', $item) }}" class="native-btn native-btn-secondary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data pemberian obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
