{{-- resources/views/obats/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h3><i class="fas fa-capsules"></i> Data Obat</h3>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('obats.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Obat
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-filter"></i> Filter Data Obat
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('obats.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Nama Obat</label>
                <input type="text" name="filter_nama_obat" class="form-control" 
                       placeholder="Cari nama obat..." value="{{ request('filter_nama_obat') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Bentuk Sediaan</label>
                <select name="filter_bentuk" class="form-select">
                    <option value="">Semua</option>
                    <option value="tablet" {{ request('filter_bentuk') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="kapsul" {{ request('filter_bentuk') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="sirup" {{ request('filter_bentuk') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="salep" {{ request('filter_bentuk') == 'salep' ? 'selected' : '' }}>Salep</option>
                    <option value="krim" {{ request('filter_bentuk') == 'krim' ? 'selected' : '' }}>Krim</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status Stok</label>
                <select name="filter_stok" class="form-select">
                    <option value="">Semua</option>
                    <option value="menipis" {{ request('filter_stok') == 'menipis' ? 'selected' : '' }}>Stok Menipis (&lt;10)</option>
                    <option value="habis" {{ request('filter_stok') == 'habis' ? 'selected' : '' }}>Stok Habis (0)</option>
                    <option value="tersedia" {{ request('filter_stok') == 'tersedia' ? 'selected' : '' }}>Stok Tersedia (&gt;0)</option>
                </select>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('obats.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="data-table">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Bentuk Sediaan</th>
                    <th>Kekuatan Dosis</th>
                    <th>Stok</th>
                    <th>Informasi Obat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($obats as $index => $obat)
                <tr>
                    <td>{{ $index + $obats->firstItem() }}</td>
                    <td>
                        <strong>{{ $obat->nama_obat }}</strong>
                        <br><small class="text-muted">ID: #{{ $obat->id }}</small>
                    </td>
                    <td>{{ $obat->bentuk_sediaan }}</td>
                    <td>{{ $obat->kekuatan_dosis }}</td>
                    <td>
                        @if($obat->stok < 10)
                            <span class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> {{ $obat->stok }}
                            </span>
                        @else
                            <span class="text-success">{{ $obat->stok }}</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#infoModal{{ $obat->id }}">
                            <i class="fas fa-info-circle"></i> Lihat Info
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('obats.edit', $obat->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('obats.cetak', $obat->id) }}" class="btn btn-sm btn-secondary" target="_blank">
    <i class="fas fa-print"></i> Cetak
</a>
                        <form action="{{ route('obats.destroy', $obat->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data obat</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">
        {{ $obats->links() }}
    </div>
</div>

<!-- Modal Info Obat (sama seperti sebelumnya) -->
@foreach($obats as $obat)
@if($obat->informasiObat)
<div class="modal fade" id="infoModal{{ $obat->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Informasi {{ $obat->nama_obat }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="info-box">
                    <strong>Indikasi:</strong><br> {{ $obat->informasiObat->indikasi_penyakit }}
                </div>
                <div class="info-box mt-2">
                    <strong>Efek Samping:</strong><br> {{ $obat->informasiObat->efek_samping_umum }}
                </div>
                <div class="info-box mt-2">
                    <strong>Tanda Bahaya:</strong><br> {{ $obat->informasiObat->tanda_bahaya }}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection