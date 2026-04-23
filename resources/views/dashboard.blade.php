{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Dashboard
            </div>
            <div class="card-body">
                <!-- Form Filter Nama -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="mb-3"><i class="fas fa-filter"></i> Filter Pemberian Obat Berdasarkan Nama Pasien</h5>
                                <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                                    <div class="col-md-8">
                                        <input type="text" name="search_nama" class="form-control" 
                                               placeholder="Cari nama pasien..." 
                                               value="{{ request('search_nama') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                    </div>
                                </form>
                                @if(request('search_nama'))
                                    <div class="mt-2">
                                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-times"></i> Hapus Filter
                                        </a>
                                        <span class="ms-2 text-muted">Menampilkan hasil untuk: "{{ request('search_nama') }}"</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stat Cards -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Pasien</h6>
                                    <h2 class="mb-0">{{ $totalPasien }}</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Obat</h6>
                                    <h2 class="mb-0">{{ $totalObat }}</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-capsules"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Pemberian Obat</h6>
                                    <h2 class="mb-0">{{ $totalPemberian }}</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-prescription"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Stok Menipis</h6>
                                    <h2 class="mb-0">{{ $stokMenipis }}</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="data-table">
            <div class="card-header">
                <i class="fas fa-clock"></i> Pemberian Obat Terbaru
                @if(request('search_nama'))
                    <span class="badge bg-info ms-2">Filter: {{ request('search_nama') }}</span>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Obat</th>
                            <th>Aturan Pakai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemberianTerbaru as $item)
                        <tr>
                            <td>{{ $item->tanggal_pemberian->format('d/m/Y') }}</td>
                            <td>{{ $item->pasien->nama }}</td>
                            <td>{{ $item->obat->nama_obat }}</td>
                            <td>{{ $item->berapa_kali_sehari }}x/hari, {{ $item->sebelum_sesudah_makan }}</td>
                            <td>
                                <a href="{{ route('pemberian_obats.show', $item) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-info-circle"></i> Info
                                </a>
                             </td>
                         </tr>
                        @empty
                         <tr>
                            <td colspan="5" class="text-center">Tidak ada data pemberian obat</td>
                         </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection