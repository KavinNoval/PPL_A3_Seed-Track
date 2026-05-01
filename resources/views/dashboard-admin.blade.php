<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('dashboard.admin') }}" class="menu-item active">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/dashboardlg.png') }}" alt="Dashboard">
            </div>
            <div class="menu-text">
                Dashboard
                <small>Laporan & Monitoring</small>
            </div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/profilperusahaan.png') }}" alt="Profil">
            </div>
            <div class="menu-text">Profil Perusahaan</div>
        </a>

        <a href="{{ route('data.staf') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Staf">
            </div>
            <div class="menu-text">Data Staf</div>
        </a>

        <a href="{{ route('data.mitra') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Mitra">
            </div>
            <div class="menu-text">Data Mitra</div>
        </a>

        <a href="{{ route('data.kios') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Kios">
            </div>
            <div class="menu-text">Data Kios</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/katalogg.png') }}" alt="Katalog">
            </div>
            <div class="menu-text">Katalog Produk</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/monitoring.png') }}" alt="Monitoring">
            </div>
            <div class="menu-text">Monitoring Lahan</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/transaksi.png') }}" alt="Transaksi">
            </div>
            <div class="menu-text">Transaksi</div>
        </a>

        <a href="#" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/pengeluaran.png') }}" alt="Pengeluaran">
            </div>
            <div class="menu-text">Pengeluaran</div>
        </a>
        
        <form action="{{ route('logout') }}" method="POST" id="formLogout" class="logout-form">
            @csrf
            <button type="button" class="menu-item btn-logout" id="btnLogoutTrigger">
                <div class="icon-circle">
                    <img src="{{ url('images/keperluandashboard/logout.png') }}" alt="Logout">
                </div>
                <div class="menu-text">Logout</div>
            </button>
        </form>
        
        <div id="modalLogout" class="modal-overlay" style="display: none;">
            <div class="modal-box">
                <p>Apakah anda yakin ingin<br>melakukan Log Out?</p>
                <div class="modal-buttons">
            <button type="button" id="btnYaLogout" class="btn-modal btn-ya">Yakin</button>
            <button type="button" id="btnBatalLogout" class="btn-modal btn-batal">Batal</button>
        </div>
    </div>
</div>

</div>
    <div class="main-content">
        <div class="topbar">
            <div class="user-info">
                <h2>{{ Auth::user()->nama_lengkap }}</h2>
                <p>{{ Auth::user()->role }}</p>
            </div>
            <div class="topbar-logo">
                Seed Track
                <img src="{{ url('images/Logo ST.png') }}" alt="Logo">
            </div>
        </div>

        <div class="greeting">
            Halo {{ Auth::user()->role }}, Selamat Datang Kembali!
        </div>

        <div class="section-title">Laporan</div>

        <div class="cards-grid">
            <div class="card">
                <div class="card-title">Total Penjualan</div>
                <div class="card-subtitle">1 Bulan Terakhir</div>
                <div class="card-value">
                    Rp. 27.450.000
                    <span class="card-trend trend-up">Penjualan &uarr; 10.4%</span>
                </div>
            </div>

            <div class="card" style="border: 2px solid #0ea5e9;">
                <div class="card-title">Total Piutang</div>
                <div class="card-subtitle">1 Bulan Terakhir</div>
                <div class="card-value">
                    Rp. 5.750.000
                    <span class="card-trend trend-up">Hutang &uarr; 14.4%</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Total Sisa Stok</div>
                <div class="card-subtitle">1 Bulan Terakhir</div>
                <div class="card-value">
                    1,2 Ton
                    <span class="card-trend trend-down">Stok &darr; 3.4%</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Est. Berat Gabah</div>
                <div class="card-subtitle">1 Bulan lagi</div>
                <div class="card-value">
                    1000 Kg
                </div>
            </div>

            <div class="card">
                <div class="card-title">Est. Berat Gabah</div>
                <div class="card-subtitle">2 Minggu lagi</div>
                <div class="card-value">
                    860 Kg
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/logout.js') }}"></script>

</html>