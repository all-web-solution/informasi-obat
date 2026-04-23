{{-- resources/views/obats/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <h4 class="mb-4"><i class="fas fa-edit"></i> Edit Obat & Informasi</h4>
            
            <form action="{{ route('obats.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Data Obat -->
                <div class="card-header mb-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-pills"></i> Data Dasar Obat
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                        <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bentuk Sediaan <span class="text-danger">*</span></label>
                        <select name="bentuk_sediaan" class="form-select" required>
                            <option value="tablet" {{ $obat->bentuk_sediaan == 'tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="kapsul" {{ $obat->bentuk_sediaan == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                            <option value="sirup" {{ $obat->bentuk_sediaan == 'sirup' ? 'selected' : '' }}>Sirup</option>
                            <option value="salep" {{ $obat->bentuk_sediaan == 'salep' ? 'selected' : '' }}>Salep</option>
                            <option value="krim" {{ $obat->bentuk_sediaan == 'krim' ? 'selected' : '' }}>Krim</option>
                            <option value="injeksi" {{ $obat->bentuk_sediaan == 'injeksi' ? 'selected' : '' }}>Injeksi</option>
                            <option value="lainnya" {{ $obat->bentuk_sediaan == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kekuatan Dosis <span class="text-danger">*</span></label>
                        <input type="text" name="kekuatan_dosis" class="form-control" value="{{ $obat->kekuatan_dosis }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control" value="{{ $obat->stok }}" required>
                    </div>
                </div>
                
                <!-- Indikasi & Efek Samping -->
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-stethoscope"></i> Indikasi & Efek Samping
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Indikasi (Untuk penyakit apa digunakan)</label>
                        <textarea name="indikasi_penyakit" class="form-control" rows="2" required>{{ $obat->informasiObat->indikasi_penyakit ?? '' }}</textarea>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Efek Samping Umum</label>
                        <textarea name="efek_samping_umum" class="form-control" rows="2" required>{{ $obat->informasiObat->efek_samping_umum ?? '' }}</textarea>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Tanda Bahaya (Harus ke Dokter)</label>
                        <textarea name="tanda_bahaya" class="form-control" rows="2" required>{{ $obat->informasiObat->tanda_bahaya ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Interaksi -->
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-exchange-alt"></i> Interaksi
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Interaksi dengan Obat Lain</label>
                        <textarea name="interaksi_obat" class="form-control" rows="2" required>{{ $obat->informasiObat->interaksi_obat ?? '' }}</textarea>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Interaksi dengan Makanan/Minuman</label>
                        <textarea name="interaksi_makanan" class="form-control" rows="2" required>{{ $obat->informasiObat->interaksi_makanan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Penyimpanan -->
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-box"></i> Penyimpanan
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Suhu Penyimpanan</label>
                        <select name="penyimpanan_suhu" class="form-select" required>
                            <option value="rak" {{ ($obat->informasiObat->penyimpanan_suhu ?? '') == 'rak' ? 'selected' : '' }}>Suhu Rak (15-30°C)</option>
                            <option value="kulkas" {{ ($obat->informasiObat->penyimpanan_suhu ?? '') == 'kulkas' ? 'selected' : '' }}>Kulkas (2-8°C)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hindari</label>
                        <div class="form-check">
                            <input type="checkbox" name="hindari_cahaya" value="1" class="form-check-input" id="hindariCahaya" {{ ($obat->informasiObat->hindari_cahaya ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hindariCahaya">Hindari cahaya langsung</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hindari_kelembaban" value="1" class="form-check-input" id="hindariKelembaban" {{ ($obat->informasiObat->hindari_kelembaban ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hindariKelembaban">Hindari kelembaban</label>
                        </div>
                    </div>
                </div>
                
                <!-- Hal Khusus -->
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-bell"></i> Hal Khusus
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-check mb-2">
                            <input type="checkbox" name="tidak_hentikan_mendadak" value="1" class="form-check-input" id="tidakHentikan" {{ ($obat->informasiObat->tidak_hentikan_mendadak ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidakHentikan">⚠️ Tidak boleh dihentikan mendadak</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="harus_dihabiskan" value="1" class="form-check-input" id="harusDihabiskan" {{ ($obat->informasiObat->harus_dihabiskan ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="harusDihabiskan">✓ Harus dihabiskan sesuai resep</label>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Cara Penggunaan Khusus</label>
                        <textarea name="cara_penggunaan_khusus" class="form-control" rows="2">{{ $obat->informasiObat->cara_penggunaan_khusus ?? '' }}</textarea>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('obats.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Obat & Informasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection