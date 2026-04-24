<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Apotek Singkut Farma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/native-fix.css') }}">
</head>
<body class="auth-page">
    <section class="auth-hero">
        <div class="auth-hero-content">
            <div class="auth-brand-mark">
                <i class="fas fa-notes-medical"></i>
            </div>

            <h1>Apotek Singkut Farma</h1>
            <p>
                Platform internal untuk mengelola data pasien, master obat, informasi obat,
                pemberian obat, edukasi pasien, dan laporan farmasi secara terintegrasi.
            </p>

            <div class="auth-hero-grid">
                <div class="auth-hero-item">
                    <i class="fas fa-users"></i>
                    <strong>Data Pasien</strong>
                    <span>Kelola identitas dan riwayat pasien.</span>
                </div>

                <div class="auth-hero-item">
                    <i class="fas fa-capsules"></i>
                    <strong>Data Obat</strong>
                    <span>Informasi indikasi, interaksi, dan penyimpanan.</span>
                </div>

                <div class="auth-hero-item">
                    <i class="fas fa-prescription"></i>
                    <strong>Pemberian Obat</strong>
                    <span>Catat aturan pakai dan edukasi obat.</span>
                </div>
            </div>
        </div>
    </section>

    <section class="auth-panel">
        <main class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">Rx</div>
                <h1>Masuk Sistem</h1>
                <p>Gunakan akun admin untuk mengakses dashboard informasi obat.</p>
            </div>

            <div class="auth-body">
                @if ($errors->any())
                    <div class="native-alert native-alert-danger">
                        <i class="fas fa-circle-exclamation me-1"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                    @csrf

                    <div class="native-form-group">
                        <label for="email">
                            <i class="fas fa-envelope me-1"></i> Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@gmail.com"
                            required
                            autofocus
                            autocomplete="email"
                        >
                    </div>

                    <div class="native-form-group">
                        <label for="password">
                            <i class="fas fa-lock me-1"></i> Password
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                        >
                    </div>

                    <label class="native-checkbox">
                        <input type="checkbox" name="remember" value="1">
                        <span>Ingat saya</span>
                    </label>

                    <button type="submit" class="native-btn native-btn-primary native-btn-block">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk
                    </button>
                </form>
            </div>
        </main>
    </section>
</body>
</html>
