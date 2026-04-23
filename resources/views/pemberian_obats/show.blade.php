@extends('layouts.app')

@section('title', 'Detail Pemberian Obat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="fas fa-prescription"></i> Detail Pemberian Obat</h4>
                <div>
                    <a href="{{ route('pemberian_obats.cetak', $pemberianObat->id) }}" class="btn btn-secondary" target="_blank">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                    <a href="{{ route('pemberian_obats.edit', $pemberianObat->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('pemberian_obats.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Tanggal Pemberian</th>
                            <td>{{ date('d F Y', strtotime($pemberianObat->tanggal_pemberian)) }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pasien</th>
                            <td>{{ $pemberianObat->pasien->nama }}</td>
                        </tr>
                        <tr>
                            <th>Umur</th>
                            <td>{{ $pemberianObat->pasien->umur }} tahun</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $pemberianObat->pasien->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa/Keluhan</th>
                            <td>{{ $pemberianObat->diagnosa_keluhan }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama Obat</th>
                            <td><strong class="text-primary">{{ $pemberianObat->obat }}</strong></td>
                        </tr>
                        <tr>
                            <th>Berapa Kali Sehari</th>
                            <td>{{ $pemberianObat->berapa_kali_sehari }} x/hari</td>
                        </tr>
                        <tr>
                            <th>Waktu Konsumsi</th>
                            <td>{{ $pemberianObat->sebelum_sesudah_makan }}</td>
                        </tr>
                        <tr>
                            <th>Lama Penggunaan</th>
                            <td>{{ $pemberianObat->lama_penggunaan_hari }} hari</td>
                        </tr>
                        @if($pemberianObat->informasi_tambahan)
                        <tr>
                            <th>Informasi Tambahan</th>
                            <td>{{ $pemberianObat->informasi_tambahan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i> 
                <strong>Catatan:</strong> Pastikan pasien mengikuti aturan pakai yang telah ditentukan.
            </div>
        </div>
    </div>
</div>
@endsection