<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Apotek Singkut Farma')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/native-fix.css') }}">

    <style>
        *{margin:0;padding:0;box-sizing:border-box}body{font-family:'Poppins',sans-serif;background:#f0f7f0;overflow-x:hidden}.sidebar{position:fixed;left:0;top:0;height:100%;width:280px;background:linear-gradient(180deg,#1a5f1a 0%,#0d3b0d 100%);color:#fff;transition:all 0.3s ease;z-index:1000;box-shadow:2px 0 10px rgb(0 0 0 / .1);overflow-y:auto}.sidebar-header{padding:25px 20px;border-bottom:1px solid rgb(255 255 255 / .1);text-align:center}.sidebar-header h3{font-size:1.3rem;margin-bottom:5px;font-weight:700}.sidebar-header p{font-size:.8rem;opacity:.8;margin-bottom:0}.sidebar-menu{padding:20px 0}.sidebar-menu-item{padding:12px 25px;margin:5px 0;transition:all 0.3s ease;cursor:pointer}.sidebar-menu-item:hover{background:rgb(255 255 255 / .1)}.sidebar-menu-item.active{background:rgb(255 255 255 / .2);border-left:4px solid gold}.sidebar-menu-item a,.sidebar-menu-item .sidebar-logout-button{color:#fff;text-decoration:none;display:flex;align-items:center;gap:12px;font-size:1rem}.sidebar-menu-item i{width:25px;font-size:1.2rem}.sidebar-section-title{padding:10px 25px;color:rgb(255 255 255 / .55);font-size:11px;text-transform:uppercase;letter-spacing:.08em;font-weight:700}.main-content{margin-left:280px;transition:all 0.3s ease;min-height:100vh}.top-navbar{background:#fff;padding:15px 25px;box-shadow:0 2px 10px rgb(0 0 0 / .05);display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999}.menu-toggle{display:none;font-size:1.5rem;cursor:pointer;color:#1a5f1a}.top-title h5{margin:0;font-weight:800;color:#1a5f1a}.top-title span{font-size:13px;color:#6b7280}.user-info{display:flex;align-items:center;gap:15px}.user-avatar{width:40px;height:40px;background:linear-gradient(135deg,#2e7d32,#1a5f1a);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}.content-wrapper{padding:25px}.stat-card{background:#fff;border-radius:15px;padding:20px;box-shadow:0 5px 15px rgb(0 0 0 / .08);transition:transform 0.3s ease;margin-bottom:20px}.stat-card:hover{transform:translateY(-5px)}.stat-icon{width:60px;height:60px;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#2e7d32}.data-table{background:#fff;border-radius:15px;overflow:hidden;box-shadow:0 5px 15px rgb(0 0 0 / .08)}.data-table thead{background:linear-gradient(135deg,#1a5f1a,#2e7d32);color:#fff}.data-table thead th{padding:15px;font-weight:600;border:none}.data-table tbody tr:hover{background:#f0f7f0}.data-table tbody td{padding:12px 15px;vertical-align:middle}.form-card{background:#fff;border-radius:15px;padding:25px;box-shadow:0 5px 15px rgb(0 0 0 / .08)}.form-label{font-weight:600;color:#1a5f1a;margin-bottom:8px}.form-control,.form-select{border-radius:10px;border:1px solid #ddd;padding:10px 15px}.form-control:focus,.form-select:focus{border-color:#2e7d32;box-shadow:0 0 0 .2rem rgb(46 125 50 / .25)}.btn-primary{background:linear-gradient(135deg,#2e7d32,#1a5f1a);border:none;border-radius:10px;padding:10px 25px;font-weight:600}.btn-primary:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgb(46 125 50 / .3)}.modal-content{border-radius:15px}.modal-header{background:linear-gradient(135deg,#1a5f1a,#2e7d32);color:#fff;border-radius:15px 15px 0 0}.info-box{background:#e8f5e9;border-left:4px solid #2e7d32;padding:15px;border-radius:10px;margin-bottom:15px}.footer{background:#fff;padding:15px 25px;text-align:center;margin-top:30px;box-shadow:0 -2px 10px rgb(0 0 0 / .05)}.badge-success{background:#e8f5e9;color:#2e7d32;padding:5px 10px;border-radius:8px}@media (max-width:992px){.sidebar{left:-280px}.sidebar.active{left:0}.main-content{margin-left:0}.menu-toggle{display:block}.overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgb(0 0 0 / .5);z-index:999}.overlay.active{display:block}}@media print{.sidebar,.top-navbar,.footer,.btn,.no-print{display:none!important}.main-content{margin-left:0!important}.content-wrapper{padding:0!important}}
    </style>

    @stack('styles')
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-notes-medical" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
            <h3>Apotek Singkut Farma</h3>
            <p>Pemberian Informasi Obat</p>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-section-title">Menu Utama</div>

            <div class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="sidebar-menu-item {{ request()->routeIs('pasiens.*') ? 'active' : '' }}">
                <a href="{{ route('pasiens.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Data Pasien</span>
                </a>
            </div>

            <div class="sidebar-menu-item {{ request()->routeIs('obats.*') ? 'active' : '' }}">
                <a href="{{ route('obats.index') }}">
                    <i class="fas fa-capsules"></i>
                    <span>Data Obat</span>
                </a>
            </div>

            <div class="sidebar-menu-item {{ request()->routeIs('pemberian_obats.*') ? 'active' : '' }}">
                <a href="{{ route('pemberian_obats.index') }}">
                    <i class="fas fa-prescription"></i>
                    <span>Pemberian Obat</span>
                </a>
            </div>

            <div class="sidebar-menu-item {{ request()->routeIs('laporan') || request()->routeIs('cetak.*') ? 'active' : '' }}">
                <a href="{{ route('laporan') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </div>

            <div class="sidebar-section-title">Akun</div>

            <div class="sidebar-menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <a href="{{ route('profile.edit') }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Edit Profile</span>
                </a>
            </div>

            <div class="sidebar-menu-item">
                <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-form">
                    @csrf
                    <button type="submit" class="sidebar-logout-button">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="main-content">
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <div class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="top-title">
                    <h5>@yield('page-title', 'Apotek Singkut Farma')</h5>
                    <span>@yield('page-description', 'Pemberian informasi obat dan edukasi pasien')</span>
                </div>
            </div>

            <div class="user-info">
                <a href="{{ route('profile.edit') }}" style="color:#1a5f1a;text-decoration:none;font-weight:700;">
                    {{ auth()->user()->name ?? 'Admin Farmasi' }}
                </a>
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <div class="footer">
            <p class="mb-0">&copy; {{ date('Y') }} Apotek Singkut Farma | Pemberian Informasi Obat</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
