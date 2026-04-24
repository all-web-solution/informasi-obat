@extends('layouts.app')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')
@section('page-description', 'Kelola informasi akun dan ubah password pengguna')

@section('content')
    <div class="profile-page-grid">
        <div class="native-card profile-summary-card">
            <div class="profile-avatar-large">
                <i class="fas fa-user"></i>
            </div>

            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>

            <div class="profile-meta-list">
                <div class="profile-meta-item">
                    <span>Status Akun</span>
                    <strong>Aktif</strong>
                </div>

                <div class="profile-meta-item">
                    <span>Terdaftar Sejak</span>
                    <strong>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : '-' }}</strong>
                </div>

                <div class="profile-meta-item">
                    <span>Update Terakhir</span>
                    <strong>{{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') : '-' }}</strong>
                </div>
            </div>
        </div>

        <div>
            <div class="native-card">
                <div class="native-card-header">
                    <div>
                        <h1 class="native-card-title">Informasi Profile</h1>
                        <p class="native-card-subtitle">
                            Perbarui nama dan email akun yang digunakan untuk login sistem.
                        </p>
                    </div>
                </div>

                @if ($errors->profile->any())
                    <div class="native-alert native-alert-danger">
                        {{ $errors->profile->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="native-form-grid">
                        <div class="native-form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                autocomplete="name">
                        </div>

                        <div class="native-form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                autocomplete="email">
                        </div>
                    </div>

                    <div class="native-actions">
                        <button type="submit" class="native-btn native-btn-primary">
                            <i class="fas fa-save"></i> Simpan Profile
                        </button>
                    </div>
                </form>
            </div>

            <div class="native-card">
                <div class="native-card-header">
                    <div>
                        <h2 class="native-card-title">Ubah Password</h2>
                        <p class="native-card-subtitle">
                            Gunakan password yang kuat agar akun tetap aman.
                        </p>
                    </div>
                </div>

                @if ($errors->password->any())
                    <div class="native-alert native-alert-danger">
                        {{ $errors->password->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="native-form-grid">
                        <div class="native-form-group">
                            <label>Password Lama</label>
                            <input type="password" name="current_password" required autocomplete="current-password">
                        </div>

                        <div class="native-form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" required autocomplete="new-password">
                            <small class="text-muted">Minimal 8 karakter, mengandung huruf dan angka.</small>
                        </div>

                        <div class="native-form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="native-actions">
                        <button type="submit" class="native-btn native-btn-primary">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
