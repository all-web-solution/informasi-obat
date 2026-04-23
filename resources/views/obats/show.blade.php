{{-- resources/views/obats/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Obat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <h4 class="mb-4"><i class="fas fa-info-circle"></i> Detail Lengkap Obat</h4>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <strong><i class="fas fa-capsules"></i> Nama Obat:</strong><br>
                        <h5>{{ $obat->nama_obat }}</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong><i class="fas fa-pills"></i> Bentuk Sediaan:</strong><br>
                        {{ $obat->bentuk_sediaan }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong><i class="fas fa-weight"></i> Kekuatan Dosis:</strong><br>
                        {{ $obat->kekuatan_dosis }}
                    </div>
                </div>
            </div>
            
            @if($obat->informasiObat)
                @php $info = $obat->informasiObat; @endphp
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="info-box">
                            <strong class="text-success">📋 INDIKASI:</strong><br>
                            {{ $info->indikasi_penyakit }}
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="info-box">
                            <strong class="text-warning">⚠️ EFEK SAMPING UMUM:</strong><br>
                            {{ $info->efek_samping_umum }}
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="info-box">
                            <strong class="text-danger">🚨 TANDA BAHAYA:</strong><br>
                            {{ $info->tanda_bahaya }}
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>💊 INTERAKSI OBAT:</strong><br>
                            {{ $info->interaksi_obat }}
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>🍽️ INTERAKSI MAKANAN:</strong><br>
                            {{ $info->interaksi_makanan }}
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>📦 PENYIMPANAN:</strong><br>
                            Suhu: {{ $info->penyimpanan_suhu }}<br>
                            @if($info->hindari_cahaya) ✔ Hindari cahaya langsung<br> @endif
                            @if($info->hindari_kelembaban) ✔ Hindari kelembaban @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>🔔 HAL KHUSUS:</strong><br>
                            @if($info->tidak_hentikan_mendadak) ⚠️ Tidak boleh dihentikan mendadak<br> @endif
                            @if($info->harus_dihabiskan) ✓ Harus dihabiskan sesuai resep<br> @endif
                            @if($info->cara_penggunaan_khusus) 📌 {{ $info->cara_penggunaan_khusus }} @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('obats.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('obats.edit', $obat->id) }}" class="btn btn-primary ms-2">
                    <i class="fas fa-edit"></i> Edit Obat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection