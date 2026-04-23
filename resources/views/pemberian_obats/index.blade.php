@extends('layouts.app')

@section('title', 'Pemberian Obat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="fas fa-prescription"></i> Data Pemberian Obat</h4>
                <a href="{{ route('pemberian_obats.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pemberian Obat
                </a>
            </div>

            <form method="GET" action="{{ route('pemberian_obats.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Filter Pasien</label>
                        <select name="filter_pasien" class="form-select">
                            <option value="">Semua Pasien</option>
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id }}" {{ request('filter_pasien') == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter Tanggal</label>
                        <input type="date" name="filter_tanggal" class="form-control" value="{{ request('filter_tanggal') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <a href="{{ route('pemberian_obats.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tgl Pemberian</th>
                            <th>Pasien</th>
                            <th>Diagnosa/Keluhan</th>
                            <th>Obat</th>
                            <th>Aturan Pakai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemberianObats as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pemberianObats->currentPage() - 1) * $pemberianObats->perPage() }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->tanggal_pemberian)) }}</td>
                            <td>{{ $item->pasien->nama }}</td>
                            <td>{{ Str::limit($item->diagnosa_keluhan, 50) }}</td>
                            <td>{{ $item->obat }}</td>
                            <td>{{ $item->berapa_kali_sehari }}x/hari, {{ $item->sebelum_sesudah_makan }}, {{ $item->lama_penggunaan_hari }} hari</td>
                            <td class="text-nowrap">
                                <a href="{{ route('pemberian_obats.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pemberian_obats.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('pemberian_obats.cetak', $item->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <form action="{{ route('pemberian_obats.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $pemberianObats->links() }}
        </div>
    </div>
</div>
@endsection