{{-- resources/views/pasiens/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h3><i class="fas fa-users"></i> Data Pasien</h3>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('pasiens.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pasien
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-filter"></i> Filter Data Pasien
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('pasiens.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Nama Pasien</label>
                <input type="text" name="filter_nama" class="form-control" 
                       placeholder="Cari nama..." value="{{ request('filter_nama') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="filter_jk" class="form-select">
                    <option value="">Semua</option>
                    <option value="Laki-laki" {{ request('filter_jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('filter_jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Umur Min</label>
                <input type="number" name="filter_umur_min" class="form-control" 
                       placeholder="Min" value="{{ request('filter_umur_min') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Umur Max</label>
                <input type="number" name="filter_umur_max" class="form-control" 
                       placeholder="Max" value="{{ request('filter_umur_max') }}">
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('pasiens.index') }}" class="btn btn-secondary">
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
                    <th>Nama Lengkap</th>
                    <th>Umur</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </td>
            </thead>
            <tbody>
                @forelse($pasiens as $index => $pasien)
                <tr>
                    <td>{{ $index + $pasiens->firstItem() }}</td>
                    <td>
                        <strong>{{ $pasien->nama }}</strong>
                        <br><small class="text-muted">ID: #{{ $pasien->id }}</small>
                    </td>
                    <td>{{ $pasien->umur }} tahun</td>
                    <td>{{ date('d/m/Y', strtotime($pasien->tanggal_lahir)) }}</td>
                    <td>
                        <span class="badge-success">
                            <i class="fas {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'fa-mars' : 'fa-venus' }}"></i>
                            {{ $pasien->jenis_kelamin }}
                        </span>
                    </td>
                    <td>{{ Str::limit($pasien->alamat, 30) }}</td>
                    <td>
                        <a href="{{ route('pasiens.show', $pasien->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('pasiens.edit', $pasien->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('pasiens.cetak', $pasien->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                        <form action="{{ route('pasiens.destroy', $pasien->id) }}" method="POST" class="d-inline">
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
                    <td colspan="7" class="text-center">Tidak ada data pasien</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">
        {{ $pasiens->links() }}
    </div>
</div>
@endsection