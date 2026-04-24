@extends('layouts.app')

@section('content')
<div class="native-card">
    <div class="native-card-header">
        <div>
            <h1 class="native-card-title">Tambah Pemberian Obat</h1>
            <p class="native-card-subtitle">Pilih pasien dan obat dari master data</p>
        </div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary">Kembali</a>
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
                            {{ $pasien->nama }} - {{ $pasien->umur }} tahun
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Obat</label>
                <select name="obat_id" id="obat_id" required>
                    <option value="">Pilih Obat</option>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" @selected(old('obat_id') == $obat->id)>
                            {{ $obat->nama_obat }} {{ $obat->kekuatan_dosis }} - {{ $obat->bentuk_sediaan }} | Stok: {{ $obat->stok }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="native-form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required>
            </div>

            <div class="native-form-group">
                <label>Tanggal Pemberian</label>
                <input type="date" name="tanggal_pemberian" value="{{ old('tanggal_pemberian', date('Y-m-d')) }}" required>
            </div>

            <div class="native-form-group">
                <label>Berapa Kali Sehari</label>
                <input type="number" name="berapa_kali_sehari" value="{{ old('berapa_kali_sehari', 3) }}" min="1" max="10" required>
            </div>

            <div class="native-form-group">
                <label>Waktu Minum</label>
                <select name="sebelum_sesudah_makan" required>
                    <option value="sebelum makan" @selected(old('sebelum_sesudah_makan') === 'sebelum makan')>Sebelum makan</option>
                    <option value="sesudah makan" @selected(old('sebelum_sesudah_makan', 'sesudah makan') === 'sesudah makan')>Sesudah makan</option>
                    <option value="tidak berpengaruh" @selected(old('sebelum_sesudah_makan') === 'tidak berpengaruh')>Tidak berpengaruh</option>
                </select>
            </div>

            <div class="native-form-group">
                <label>Lama Penggunaan Hari</label>
                <input type="number" name="lama_penggunaan_hari" value="{{ old('lama_penggunaan_hari', 3) }}" min="1" max="365" required>
            </div>

            <div class="native-form-group">
                <label>Diagnosa/Keluhan</label>
                <textarea name="diagnosa_keluhan" rows="3" required>{{ old('diagnosa_keluhan') }}</textarea>
            </div>

            <div class="native-form-group" style="grid-column: 1 / -1;">
                <label>Informasi Tambahan</label>
                <textarea name="informasi_tambahan" rows="3">{{ old('informasi_tambahan') }}</textarea>
            </div>
        </div>

        <div id="obat-info-box" class="native-card" style="display:none; margin-top:16px;"></div>

        <div class="native-actions">
            <a href="{{ route('pemberian_obats.index') }}" class="native-btn native-btn-secondary">Batal</a>
            <button type="submit" class="native-btn native-btn-primary">Simpan Pemberian Obat</button>
        </div>
    </form>
</div>

<script>
document.getElementById('obat_id').addEventListener('change', function () {
    const id = this.value;
    const box = document.getElementById('obat-info-box');

    if (!id) {
        box.style.display = 'none';
        box.innerHTML = '';
        return;
    }

    fetch(`/get-obat-info/${id}`)
        .then(response => response.json())
        .then(data => {
            if (!data || Object.keys(data).length === 0) {
                box.style.display = 'none';
                box.innerHTML = '';
                return;
            }

            box.style.display = 'block';
            box.innerHTML = `
                <h3 class="native-card-title">Informasi Obat</h3>
                <div class="native-detail-grid">
                    <div class="native-detail-item">
                        <div class="native-detail-label">Indikasi</div>
                        <div class="native-detail-value">${data.indikasi_penyakit || '-'}</div>
                    </div>
                    <div class="native-detail-item">
                        <div class="native-detail-label">Efek Samping</div>
                        <div class="native-detail-value">${data.efek_samping_umum || '-'}</div>
                    </div>
                    <div class="native-detail-item">
                        <div class="native-detail-label">Tanda Bahaya</div>
                        <div class="native-detail-value">${data.tanda_bahaya || '-'}</div>
                    </div>
                    <div class="native-detail-item">
                        <div class="native-detail-label">Penyimpanan</div>
                        <div class="native-detail-value">${data.penyimpanan_suhu || '-'}</div>
                    </div>
                </div>
            `;
        });
});
</script>
@endsection
