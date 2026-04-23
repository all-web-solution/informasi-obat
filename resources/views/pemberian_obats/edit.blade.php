@extends('layouts.app')

@section('title', 'Edit Pemberian Obat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <h4 class="mb-4"><i class="fas fa-edit"></i> Form Edit Pemberian Obat</h4>
            
            <form action="{{ route('pemberian_obats.update', $pemberianObat->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilih Pasien <span class="text-danger">*</span></label>
                        <select name="pasien_id" class="form-select @error('pasien_id') is-invalid @enderror" required>
                            <option value="">Pilih Pasien</option>
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id }}" {{ old('pasien_id', $pemberianObat->pasien_id) == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->nama }} ({{ $pasien->umur }} th, {{ $pasien->jenis_kelamin }})
                                </option>
                            @endforeach
                        </select>
                        @error('pasien_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pemberian <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pemberian" class="form-control @error('tanggal_pemberian') is-invalid @enderror" value="{{ old('tanggal_pemberian', $pemberianObat->tanggal_pemberian) }}" required>
                        @error('tanggal_pemberian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                        <input type="text" name="obat" class="form-control @error('obat') is-invalid @enderror" value="{{ old('obat', $pemberianObat->obat) }}" required>
                        @error('obat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Diagnosa / Keluhan <span class="text-danger">*</span></label>
                        <textarea name="diagnosa_keluhan" class="form-control @error('diagnosa_keluhan') is-invalid @enderror" rows="2" required>{{ old('diagnosa_keluhan', $pemberianObat->diagnosa_keluhan) }}</textarea>
                        @error('diagnosa_keluhan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="card-header mb-3 mt-3" style="background: #e8f5e9; color: #1a5f1a;">
                    <i class="fas fa-clock"></i> Aturan Penggunaan
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Berapa Kali Sehari <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="berapa_kali_sehari" class="form-control @error('berapa_kali_sehari') is-invalid @enderror" min="1" max="10" value="{{ old('berapa_kali_sehari', $pemberianObat->berapa_kali_sehari) }}" required>
                            <span class="input-group-text">x/hari</span>
                        </div>
                        @error('berapa_kali_sehari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Waktu Konsumsi <span class="text-danger">*</span></label>
                        <select name="sebelum_sesudah_makan" class="form-select @error('sebelum_sesudah_makan') is-invalid @enderror" required>
                            <option value="sebelum makan" {{ old('sebelum_sesudah_makan', $pemberianObat->sebelum_sesudah_makan) == 'sebelum makan' ? 'selected' : '' }}>Sebelum Makan</option>
                            <option value="sesudah makan" {{ old('sebelum_sesudah_makan', $pemberianObat->sebelum_sesudah_makan) == 'sesudah makan' ? 'selected' : '' }}>Sesudah Makan</option>
                            <option value="tidak berpengaruh" {{ old('sebelum_sesudah_makan', $pemberianObat->sebelum_sesudah_makan) == 'tidak berpengaruh' ? 'selected' : '' }}>Tidak Berpengaruh</option>
                        </select>
                        @error('sebelum_sesudah_makan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Lama Penggunaan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="lama_penggunaan_hari" class="form-control @error('lama_penggunaan_hari') is-invalid @enderror" min="1" max="365" value="{{ old('lama_penggunaan_hari', $pemberianObat->lama_penggunaan_hari) }}" required>
                            <span class="input-group-text">hari</span>
                        </div>
                        @error('lama_penggunaan_hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Informasi Tambahan</label>
                        <textarea name="informasi_tambahan" class="form-control" rows="2" placeholder="Contoh: Minum air putih yang cukup, Jangan dikonsumsi bersamaan dengan obat lain, dll">{{ old('informasi_tambahan', $pemberianObat->informasi_tambahan) }}</textarea>
                        <small class="text-muted">Informasi tambahan untuk pasien (opsional)</small>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('pemberian_obats.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Pemberian Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection