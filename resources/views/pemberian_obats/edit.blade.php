@extends('layouts.app')

@section('title', 'Edit Pemberian Obat')
@section('page-title', 'Edit Pemberian Obat')
@section('page-description', 'Perbarui obat dan aturan pakai pasien')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Edit Pemberian Obat</h1>
            <p class="native-card-subtitle">Perbarui data pemberian obat dalam format field gabungan.</p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.show', $pemberianObat) }}" class="native-btn native-btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="native-alert native-alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="native-alert native-alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('pemberian_obats.update', $pemberianObat) }}">
        @csrf
        @method('PUT')

        <div class="native-form-grid">
            <div class="native-form-group">
                <label>Pasien</label>
                <select name="pasien_id" required>
                    @foreach($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" @selected(old('pasien_id', $pemberianObat->pasien_id) == $pasien->id)>
                            {{ $pasien->nama }} - {{ $pasien->umur }} tahun - {{ $pasien->jenis_kelamin }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Tanggal Pemberian</label>
                <input
                    type="date"
                    name="tanggal_pemberian"
                    value="{{ old('tanggal_pemberian', \Carbon\Carbon::parse($pemberianObat->tanggal_pemberian)->format('Y-m-d')) }}"
                    required
                >
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Obat dan Aturan Pakai</label>
                <textarea name="obat_aturan_pakai" rows="6" required>{{ old('obat_aturan_pakai', $pemberianObat->obat_aturan_pakai) }}</textarea>
                <small class="text-muted">
                    Tulis obat, dosis, jumlah bila perlu, waktu minum, durasi, dan instruksi khusus dalam satu field.
                </small>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Diagnosa/Keluhan</label>
                <textarea name="diagnosa_keluhan" rows="4" required>{{ old('diagnosa_keluhan', $pemberianObat->diagnosa_keluhan) }}</textarea>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Informasi Tambahan</label>
                <textarea name="informasi_tambahan" rows="3">{{ old('informasi_tambahan', $pemberianObat->informasi_tambahan) }}</textarea>
            </div>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.show', $pemberianObat) }}" class="native-btn native-btn-secondary">
                Batal
            </a>
            <button type="submit" class="native-btn native-btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
