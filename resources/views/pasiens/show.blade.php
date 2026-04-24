@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')
@section('page-description', 'Informasi pasien dan riwayat pemberian obat')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Detail Pasien</h1>
            <p class="native-card-subtitle">Informasi pasien dan riwayat pemberian obat</p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pasiens.index') }}" class="native-btn native-btn-secondary">Kembali</a>
            <a href="{{ route('pasiens.edit', $pasien) }}" class="native-btn native-btn-primary">Edit Pasien</a>
            <a href="{{ route('pemberian_obats.create', ['pasien_id' => $pasien->id]) }}" class="native-btn native-btn-success">Beri Obat</a>
            <a href="{{ route('pasiens.cetak', $pasien) }}" target="_blank" class="native-btn native-btn-info">Cetak</a>
        </div>
    </div>

    <div class="native-detail-grid">
        <div class="native-detail-item">
            <div class="native-detail-label">Nama Pasien</div>
            <div class="native-detail-value">{{ $pasien->nama }}</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Umur</div>
            <div class="native-detail-value">{{ $pasien->umur }} tahun</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Tanggal Lahir</div>
            <div class="native-detail-value">
                {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d/m/Y') : '-' }}
            </div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Jenis Kelamin</div>
            <div class="native-detail-value">{{ $pasien->jenis_kelamin }}</div>
        </div>

        <div class="native-detail-item" style="grid-column: 1 / -1;">
            <div class="native-detail-label">Alamat</div>
            <div class="native-detail-value">{{ $pasien->alamat }}</div>
        </div>

        <div class="native-detail-item">
            <div class="native-detail-label">Total Pemberian Obat</div>
            <div class="native-detail-value">{{ $totalPemberian }} pemberian</div>
        </div>
    </div>
</div>

<div class="native-card">
    <div class="native-card-header">
        <div>
            <h2 class="native-card-title">Riwayat Pemberian Obat</h2>
            <p class="native-card-subtitle">Daftar obat dan aturan pakai yang pernah diberikan kepada pasien</p>
        </div>
    </div>

    <div class="native-table-wrapper">
        <table class="native-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Obat dan Aturan Pakai</th>
                    <th>Diagnosa/Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatObat as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') }}</td>
                        <td>{{ $item->ringkasan_obat }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->diagnosa_keluhan, 80) }}</td>
                        <td>
                            <a href="{{ route('pemberian_obats.show', $item) }}" class="native-btn native-btn-secondary">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada riwayat pemberian obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
