{{-- resources/views/pasiens/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="fas fa-user-edit"></i> Form Edit Pasien</h4>
                <a href="{{ route('pasiens.show', $pasien->id) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
            </div>
            
            <form action="{{ route('pasiens.update', $pasien->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $pasien->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Umur (Tahun) <span class="text-danger">*</span></label>
                        <input type="number" name="umur" class="form-control @error('umur') is-invalid @enderror" 
                               value="{{ old('umur', $pasien->umur) }}" required>
                        @error('umur')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                               value="{{ old('tanggal_lahir', $pasien->tanggal_lahir->format('Y-m-d')) }}" required>
                        @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('pasiens.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('pasiens.show', $pasien->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Data Pasien
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection