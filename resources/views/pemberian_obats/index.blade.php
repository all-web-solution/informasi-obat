@extends('layouts.app')

@section('title', 'Pemberian Obat')
@section('page-title', 'Pemberian Obat')
@section('page-description', 'Kelola riwayat pemberian obat kepada pasien')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Data Pemberian Obat</h1>
            <p class="native-card-subtitle">Daftar pemberian obat beserta pasien, obat, aturan pakai, dan diagnosa.</p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.create') }}" class="native-btn native-btn-primary">
                <i class="fas fa-plus"></i> Tambah Pemberian
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('pemberian_obats.index') }}" class="mb-3">
        <div class="native-form-grid">
            <div class="native-form-group">
                <label>Filter Pasien</label>
                <select name="filter_pasien">
                    <option value="">Semua Pasien</option>
                    @foreach($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" @selected(request('filter_pasien') == $pasien->id)>
                            {{ $pasien->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Filter Obat</label>
                <select name="filter_obat">
                    <option value="">Semua Obat</option>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" @selected(request('filter_obat') == $obat->id)>
                            {{ $obat->nama_obat }} {{ $obat->kekuatan_dosis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Filter Tanggal</label>
                <input type="date" name="filter_tanggal" value="{{ request('filter_tanggal') }}">
            </div>

            <div class="native-actions" style="align-items:end;">
                <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="native-btn native-btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </form>

    <div class="native-table-wrapper">
        <table class="native-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Obat</th>
                    <th>Aturan Pakai</th>
                    <th>Diagnosa/Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemberianObats as $index => $item)
                    <tr>
                        <td>{{ $pemberianObats->firstItem() + $index }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $item->pasien->nama ?? '-' }}</strong><br>
                            <small class="text-muted">
                                {{ $item->pasien->jenis_kelamin ?? '-' }} | {{ $item->pasien->umur ?? '-' }} tahun
                            </small>
                        </td>
                        <td>
                            <div class="medicine-card-inline">
                                <div class="medicine-icon">
                                    <i class="fas fa-capsules"></i>
                                </div>
                                <div>
                                    <div class="medicine-name">{{ $item->nama_obat_display }}</div>
                                    <div class="medicine-meta">{{ $item->detail_obat_display }}</div>
                                    <div class="medicine-badges">
                                        <span class="medicine-badge">{{ $item->jumlah }} unit</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->aturan_pakai_display }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->diagnosa_keluhan, 70) }}</td>
                        <td>
                            <div class="native-actions" style="justify-content:flex-start;">
                                <a href="{{ route('pemberian_obats.show', $item) }}" class="native-btn native-btn-secondary">
                                    Detail
                                </a>
                                <a href="{{ route('pemberian_obats.edit', $item) }}" class="native-btn native-btn-primary">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada data pemberian obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pemberianObats->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $pemberianObats->firstItem() }} - {{ $pemberianObats->lastItem() }}
                dari {{ $pemberianObats->total() }} data
            </div>
            <div>
                {{ $pemberianObats->onEachSide(1)->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
