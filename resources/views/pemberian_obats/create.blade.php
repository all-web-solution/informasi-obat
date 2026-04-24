@extends('layouts.app')

@section('title', 'Tambah Pemberian Obat')
@section('page-title', 'Tambah Pemberian Obat')
@section('page-description', 'Catat obat dan aturan pakai dalam satu field edukasi pasien')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Tambah Pemberian Obat</h1>
            <p class="native-card-subtitle">
                Isi obat dan aturan pakai dalam satu field panjang sesuai revisi kebutuhan customer.
            </p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary">
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

    <form method="POST" action="{{ route('pemberian_obats.store') }}">
        @csrf

        <div class="native-form-grid">
            <div class="native-form-group">
                <label>Pasien</label>
                <select name="pasien_id" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" @selected(old('pasien_id', request('pasien_id')) == $pasien->id)>
                            {{ $pasien->nama }} - {{ $pasien->umur }} tahun - {{ $pasien->jenis_kelamin }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Tanggal Pemberian</label>
                <input type="date" name="tanggal_pemberian" value="{{ old('tanggal_pemberian', date('Y-m-d')) }}" required>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Obat dan Aturan Pakai</label>
                <textarea
                    name="obat_aturan_pakai"
                    rows="6"
                    required
                    placeholder="Contoh:
Paracetamol 500 mg tablet
Aturan pakai: 3 x 1 tablet sesudah makan bila demam atau nyeri.
Jumlah: 10 tablet.

Cetirizine 10 mg tablet
Aturan pakai: 1 x 1 tablet malam hari bila gatal.">{{ old('obat_aturan_pakai') }}</textarea>
                <small class="text-muted">
                    Tulis nama obat, dosis, jumlah bila perlu, waktu minum, durasi, dan instruksi khusus dalam satu field.
                </small>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Diagnosa/Keluhan</label>
                <textarea name="diagnosa_keluhan" rows="4" required>{{ old('diagnosa_keluhan') }}</textarea>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Informasi Tambahan</label>
                <textarea name="informasi_tambahan" rows="3">{{ old('informasi_tambahan') }}</textarea>
            </div>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary">
                Batal
            </a>
            <button type="submit" class="native-btn native-btn-primary">
                <i class="fas fa-save"></i> Simpan Pemberian Obat
            </button>
        </div>
    </form>
</div>
@endsection
