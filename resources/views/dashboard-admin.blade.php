<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <aside class="sidebar">
        
        <a href="{{ route('dashboard.admin') }}" class="menu-item active">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/dashboardlg.png') }}" alt="Dashboard">
            </div>
            <div class="menu-text">
                Dashboard
                <small>Laporan & Monitoring</small>
            </div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/profilperusahaan.png') }}" alt="Profil">
            </div>
            <div class="menu-text">Profil Perusahaan</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/datadata.png') }}" alt="Data Staf">
            </div>
            <div class="menu-text">Data Staf</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/dashboardlg.png') }}" alt="Data Mitra">
            </div>
            <div class="menu-text">Data Mitra</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/datadata.png') }}" alt="Data Kios">
            </div>
            <div class="menu-text">Data Kios</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/katalog.png') }}" alt="Katalog">
            </div>
            <div class="menu-text">Katalog Produk</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/monitoring.png') }}" alt="Monitoring">
            </div>
            <div class="menu-text">Monitoring Lahan</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/transaksi.png') }}" alt="Transaksi">
            </div>
            <div class="menu-text">Transaksi</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/pengeluaran.png') }}" alt="Pengeluaran">
            </div>
            <div class="menu-text">Pengeluaran</div>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="menu-item btn-logout">
                <div class="icon-circle">
                    <img src="{{ asset('images/keperluandashboard/logout.png') }}" alt="Logout">
                </div>
                <div class="menu-text">Logout</div>
            </button>
        </form>
    </aside>

    <main class="main-content">
        
        <header class="topbar">
            <div class="user-info">
                <h2>{{ Auth::user()->nama_lengkap ?? 'Budi Santoso' }}</h2>
                <p>{{ Auth::user()->role ?? 'Admin' }}</p>
            </div>
            <div class="topbar-logo">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
            </div>
        </header>

        <h1 class="greeting">Halo {{ Auth::user()->role ?? 'Admin' }}, Selamat Datang Kembali!</h1>
        
        <h2 class="section-title">Laporan</h2>

        <div class="cards-grid">
            
            <div class="card">
                <div class="card-title">Total Penjualan</div>
                <div class="card-subtitle">1 Bulan Terakhir</div>
                <div class="card-value">
                    Rp. 27.450.000
                    <span class="card-trend trend-up">↑ 10.4%</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Total Piutang</div>
                <div class="card-subtitle">1 Bulan Terakhir</div>
                <div class="card-value">
                    Rp. 5.750.000
                    <span class="card-trend trend-up">↑ 14.4%</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Total Sisa Stok</div>
                <div class="card-subtitle">1 Bulan Terakhir</div>
                <div class="card-value">
                    1,2 Ton
                    <span class="card-trend trend-down">↓ 3.4%</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Est. Berat Gabah</div>
                <div class="card-subtitle">1 Bulan lagi</div>
                <div class="card-value">1000 Kg</div>
            </div>

            <div class="card">
                <div class="card-title">Est. Berat Gabah</div>
                <div class="card-subtitle">2 Minggu lagi</div>
                <div class="card-value">860 Kg</div>
            </div>

        </div>
    </main>

</body>
</html>