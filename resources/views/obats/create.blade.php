{{-- resources/views/obats/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <h4 class="mb-4"><i class="fas fa-capsules"></i> Form Tambah Obat & Informasi</h4>
            
            <form action="{{ route('obats.store') }}" method="POST">
                @csrf
                
                <!-- Data Obat -->
                <div class="card-header mb-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-pills"></i> Data Dasar Obat
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                        <input type="text" name="nama_obat" class="form-control @error('nama_obat') is-invalid @enderror" required>
                        @error('nama_obat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bentuk Sediaan <span class="text-danger">*</span></label>
                        <select name="bentuk_sediaan" class="form-select @error('bentuk_sediaan') is-invalid @enderror" required>
                            <option value="">Pilih Bentuk Sediaan</option>
                            <option value="tablet">Tablet</option>
                            <option value="kapsul">Kapsul</option>
                            <option value="sirup">Sirup</option>
                            <option value="salep">Salep</option>
                            <option value="krim">Krim</option>
                            <option value="injeksi">Injeksi</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        @error('bentuk_sediaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kekuatan Dosis <span class="text-danger">*</span></label>
                        <input type="text" name="kekuatan_dosis" class="form-control @error('kekuatan_dosis') is-invalid @enderror" placeholder="Contoh: 500mg, 10mg/ml, 5%" required>
                        @error('kekuatan_dosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" required>
                        @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <!-- Indikasi & Efek Samping -->
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-stethoscope"></i> Indikasi & Efek Samping
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Indikasi (Untuk penyakit apa digunakan) <span class="text-danger">*</span></label>
                        <textarea name="indikasi_penyakit" class="form-control @error('indikasi_penyakit') is-invalid @enderror" rows="2" required></textarea>
                        <small class="text-muted">Contoh: Hipertensi, Infeksi bakteri, Asma, dll</small>
                        @error('indikasi_penyakit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Efek Samping Umum <span class="text-danger">*</span></label>
                        <textarea name="efek_samping_umum" class="form-control @error('efek_samping_umum') is-invalid @enderror" rows="2" required></textarea>
                        @error('efek_samping_umum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Tanda Bahaya (Harus ke Dokter) <span class="text-danger">*</span></label>
                        <textarea name="tanda_bahaya" class="form-control @error('tanda_bahaya') is-invalid @enderror" rows="2" required></textarea>
                        @error('tanda_bahaya')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <!-- Interaksi -->
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-exchange-alt"></i> Interaksi
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Interaksi dengan Obat Lain <span class="text-danger">*</span></label>
                        <textarea name="interaksi_obat" class="form-control @error('interaksi_obat') is-invalid @enderror" rows="2" required></textarea>
                        @error('interaksi_obat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Interaksi dengan Makanan/Minuman <span class="text-danger">*</span></label>
                        <textarea name="interaksi_makanan" class="form-control @error('interaksi_makanan') is-invalid @enderror" rows="2" required></textarea>
                        @error('interaksi_makanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <!-- Penyimpanan -->
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-box"></i> Penyimpanan
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Suhu Penyimpanan <span class="text-danger">*</span></label>
                        <select name="penyimpanan_suhu" class="form-select @error('penyimpanan_suhu') is-invalid @enderror" required>
                            <option value="rak">Suhu Rak (15-30°C)</option>
                            <option value="kulkas">Kulkas (2-8°C)</option>
                        </select>
                        @error('penyimpanan_suhu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hindari</label>
                        <div class="form-check">
                            <input type="checkbox" name="hindari_cahaya" value="1" class="form-check-input" id="hindariCahaya">
                            <label class="form-check-label" for="hindariCahaya">Hindari cahaya langsung</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hindari_kelembaban" value="1" class="form-check-input" id="hindariKelembaban">
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
                            <input type="checkbox" name="tidak_hentikan_mendadak" value="1" class="form-check-input" id="tidakHentikan">
                            <label class="form-check-label" for="tidakHentikan">
                                ⚠️ Tidak boleh dihentikan mendadak
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="harus_dihabiskan" value="1" class="form-check-input" id="harusDihabiskan">
                            <label class="form-check-label" for="harusDihabiskan">
                                ✓ Harus dihabiskan sesuai resep
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Cara Penggunaan Khusus</label>
                        <textarea name="cara_penggunaan_khusus" class="form-control" rows="2" placeholder="Contoh: Minum pada jam yang sama setiap hari, Kocok dahulu sebelum digunakan, dll"></textarea>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('obats.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Obat & Informasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection