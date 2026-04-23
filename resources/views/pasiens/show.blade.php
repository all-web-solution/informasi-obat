{{-- resources/views/pasiens/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="fas fa-user-circle"></i> Detail Data Pasien</h4>
                <div>
                    <a href="{{ route('pasiens.edit', $pasien->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Pasien
                    </a>
                    <a href="{{ route('pasiens.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            
            <!-- Informasi Pasien -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header mb-3" style="background: #e8f5e9; color: #1a5f1a;">
                        <i class="fas fa-id-card"></i> Informasi Personal
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="info-box">
                        <strong><i class="fas fa-user"></i> Nama Lengkap:</strong><br>
                        <h5 class="mt-2">{{ $pasien->nama }}</h5>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="info-box">
                        <strong><i class="fas fa-calendar-alt"></i> Umur:</strong><br>
                        <span class="fs-3">{{ $pasien->umur }}</span> tahun
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="info-box">
                        <strong><i class="fas fa-birthday-cake"></i> Tanggal Lahir:</strong><br>
                        {{ $pasien->tanggal_lahir->format('d F Y') }}
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="info-box">
                        <strong><i class="fas fa-venus-mars"></i> Jenis Kelamin:</strong><br>
                        <span class="badge-success">
                            <i class="fas {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'fa-mars' : 'fa-venus' }}"></i>
                            {{ $pasien->jenis_kelamin }}
                        </span>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="info-box">
                        <strong><i class="fas fa-map-marker-alt"></i> Alamat Lengkap:</strong><br>
                        {{ $pasien->alamat }}
                    </div>
                </div>
            </div>
            
            <!-- Statistik -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card-header mb-3" style="background: #e8f5e9; color: #1a5f1a;">
                        <i class="fas fa-chart-bar"></i> Statistik Pasien
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card text-center">
                        <h3>{{ $totalPemberian }}</h3>
                        <p class="text-muted mb-0">Total Pemberian Obat</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card text-center">
                        <h3>{{ $pasien->pemberianObat->groupBy('obat_id')->count() }}</h3>
                        <p class="text-muted mb-0">Jenis Obat yang Pernah Diberikan</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card text-center">
                        <h3>{{ $pasien->pemberianObat->sum('jumlah') }}</h3>
                        <p class="text-muted mb-0">Total Item Obat</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card text-center">
                        <h3>{{ $pasien->created_at->format('d/m/Y') }}</h3>
                        <p class="text-muted mb-0">Terdaftar Sejak</p>
                    </div>
                </div>
            </div>
            
            <!-- Riwayat Pemberian Obat -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card-header mb-3" style="background: #e8f5e9; color: #1a5f1a;">
                        <i class="fas fa-history"></i> Riwayat Pemberian Obat
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Aturan Pakai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatObat as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->tanggal_pemberian->format('d/m/Y') }}</td>
                                    <td>{{ $riwayat->obat->nama_obat }}<br>
                                        <small>{{ $riwayat->obat->kekuatan_dosis }}</small>
                                    </td>
                                    <td>{{ $riwayat->jumlah }} {{ $riwayat->obat->bentuk_sediaan }}</td>
                                    <td>
                                        {{ $riwayat->berapa_kali_sehari }}x/hari<br>
                                        {{ $riwayat->sebelum_sesudah_makan }}<br>
                                        {{ $riwayat->lama_penggunaan_hari }} hari
                                    </td>
                                    <td>
                                        <a href="{{ route('pemberian_obats.show', $riwayat->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada riwayat pemberian obat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection