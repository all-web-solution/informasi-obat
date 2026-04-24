@extends('layouts.app')

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
        </div>
    </div>

    @if(session('success'))
        <div class="native-alert native-alert-success">{{ session('success') }}</div>
    @endif

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
            <div class="native-detail-value">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d/m/Y') }}</div>
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
            <p class="native-card-subtitle">Daftar obat yang pernah diberikan kepada pasien</p>
        </div>
    </div>

    <div class="native-table-wrapper">
        <table class="native-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Obat</th>
                    <th>Aturan Pakai</th>
                    <th>Diagnosa/Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatObat as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $item->obat->nama_obat ?? '-' }}</strong><br>
                            <small>{{ $item->obat->kekuatan_dosis ?? '-' }} - {{ $item->obat->bentuk_sediaan ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $item->berapa_kali_sehari }}x sehari,
                            {{ $item->sebelum_sesudah_makan }},
                            {{ $item->lama_penggunaan_hari }} hari
                        </td>
                        <td>{{ $item->diagnosa_keluhan }}</td>
                        <td>
                            <a href="{{ route('pemberian_obats.show', $item) }}" class="native-btn native-btn-secondary">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada riwayat pemberian obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
