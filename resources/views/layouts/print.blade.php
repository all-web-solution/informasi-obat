<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Cetak Laporan')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/native-fix.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="print-page">
    <div class="print-sheet">
        <div class="print-topbar">
            <button onclick="window.print()" class="native-btn native-btn-primary">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>

        <div class="print-header-modern">
            <div class="print-brand">
                <div class="print-brand-icon">
                    <i class="fas fa-notes-medical"></i>
                </div>
                <div>
                    <h1>@yield('print-title', 'Apotek Singkut Farma')</h1>
                    <p>@yield('print-subtitle', 'Pemberian Informasi Obat')</p>
                </div>
            </div>

            <div class="print-meta-box">
                <strong>Tanggal Cetak</strong><br>
                {{ now()->format('d/m/Y H:i') }}<br><br>
                <strong>Dicetak Oleh</strong><br>
                {{ auth()->user()->name ?? 'Administrator' }}
            </div>
        </div>

        @yield('content')

        <div class="print-footer">
            Dokumen ini dibuat otomatis oleh Sistem Informasi Obat Apotek Singkut Farma.
        </div>
    </div>
</body>
</html>
