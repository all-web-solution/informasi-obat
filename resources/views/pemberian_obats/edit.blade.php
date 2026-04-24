@extends('layouts.app')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Edit Pemberian Obat</h1>
            <p class="native-card-subtitle">Perbarui data pemberian obat pasien</p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.show', $pemberianObat) }}" class="native-btn native-btn-secondary">Kembali</a>
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
                            {{ $pasien->nama }} - {{ $pasien->umur }} tahun
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Obat</label>
                <select name="obat_id" required>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" @selected(old('obat_id', $pemberianObat->obat_id) == $obat->id)>
                            {{ $obat->nama_obat }} {{ $obat->kekuatan_dosis }} - {{ $obat->bentuk_sediaan }} | Stok: {{ $obat->stok }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $pemberianObat->jumlah) }}" min="1" required>
            </div>

            <div class="native-form-group">
                <label>Tanggal Pemberian</label>
                <input type="date" name="tanggal_pemberian" value="{{ old('tanggal_pemberian', \Carbon\Carbon::parse($pemberianObat->tanggal_pemberian)->format('Y-m-d')) }}" required>
            </div>

            <div class="native-form-group">
                <label>Berapa Kali Sehari</label>
                <input type="number" name="berapa_kali_sehari" value="{{ old('berapa_kali_sehari', $pemberianObat->berapa_kali_sehari) }}" min="1" max="10" required>
            </div>

            <div class="native-form-group">
                <label>Waktu Minum</label>
                <select name="sebelum_sesudah_makan" required>
                    <option value="sebelum makan" @selected(old('sebelum_sesudah_makan', $pemberianObat->sebelum_sesudah_makan) === 'sebelum makan')>Sebelum makan</option>
                    <option value="sesudah makan" @selected(old('sebelum_sesudah_makan', $pemberianObat->sebelum_sesudah_makan) === 'sesudah makan')>Sesudah makan</option>
                    <option value="tidak berpengaruh" @selected(old('sebelum_sesudah_makan', $pemberianObat->sebelum_sesudah_makan) === 'tidak berpengaruh')>Tidak berpengaruh</option>
                </select>
            </div>

            <div class="native-form-group">
                <label>Lama Penggunaan Hari</label>
                <input type="number" name="lama_penggunaan_hari" value="{{ old('lama_penggunaan_hari', $pemberianObat->lama_penggunaan_hari) }}" min="1" max="365" required>
            </div>

            <div class="native-form-group">
                <label>Diagnosa/Keluhan</label>
                <textarea name="diagnosa_keluhan" rows="3" required>{{ old('diagnosa_keluhan', $pemberianObat->diagnosa_keluhan) }}</textarea>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Informasi Tambahan</label>
                <textarea name="informasi_tambahan" rows="3">{{ old('informasi_tambahan', $pemberianObat->informasi_tambahan) }}</textarea>
            </div>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.show', $pemberianObat) }}" class="native-btn native-btn-secondary">Batal</a>
            <button type="submit" class="native-btn native-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
