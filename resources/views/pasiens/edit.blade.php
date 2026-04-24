@extends('layouts.app')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Edit Pasien</h1>
            <p class="native-card-subtitle">Perbarui data identitas pasien</p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pasiens.show', $pasien) }}" class="native-btn native-btn-secondary">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="native-alert native-alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('pasiens.update', $pasien) }}">
        @csrf
        @method('PUT')

        <div class="native-form-grid">
            <div class="native-form-group">
                <label>Nama Pasien</label>
                <input type="text" name="nama" value="{{ old('nama', $pasien->nama) }}" required>
            </div>

            <div class="native-form-group">
                <label>Umur</label>
                <input type="number" name="umur" value="{{ old('umur', $pasien->umur) }}" required>
            </div>

            <div class="native-form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d')) }}" required>
            </div>

            <div class="native-form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="Laki-laki" @selected(old('jenis_kelamin', $pasien->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(old('jenis_kelamin', $pasien->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                </select>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Alamat</label>
                <textarea name="alamat" rows="4" required>{{ old('alamat', $pasien->alamat) }}</textarea>
            </div>
        </div>

        <div class="native-actions">
            <a href="{{ route('pasiens.show', $pasien) }}" class="native-btn native-btn-secondary">Batal</a>
            <button type="submit" class="native-btn native-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
