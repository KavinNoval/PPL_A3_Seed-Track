<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Staf Gudang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard-gudang.css') }}">
</head>
<body>

    <div class="top-bar">
        <div class="top-left">
            <h1>Selamat Datang Kembali {{ Auth::user()->nama_lengkap }}!</h1>
            <div class="role">{{ Auth::user()->role }}</div>
        </div>
        <div class="top-right">
            Seed Track
            <img src="{{ asset('images/Logo ST.png') }}" alt="Seed Track Logo">
        </div>
    </div>

    <div class="fitur-section">
        <h3>Fitur-Fitur</h3>
        <div class="grid-fitur">
            <a href="#" class="fitur-card">
                <div class="icon-circle">
                    <img src="{{ asset('images/dashboardgudang/katalogg.png') }}" alt="Katalog">
                </div>
                <div class="fitur-text">
                    <h4>Katalog Produk</h4>
                </div>
            </a>

            <a href="#" class="fitur-card">
                <div class="icon-circle">
                    <img src="{{ asset('images/dashboardgudang/catattransaksi.png') }}" alt="Transaksi">
                </div>
                <div class="fitur-text">
                    <h4>Pencatatan Transaksi</h4>
                </div>
            </a>

            <a href="{{ route('kios.gudang') }}" class="fitur-card">
                <div class="icon-circle">
                    <img src="{{ asset('images/dashboardgudang/datakios.png') }}" alt="Data Kios">
                </div>
                <div class="fitur-text">
                    <h4>Data Kios</h4>
                </div>
            </a>

            <a href="#" class="fitur-card">
                <div class="icon-circle">
                    <img src="{{ asset('images/dashboardgudang/pengeluaran.png') }}" alt="Pengeluaran">
                </div>
                <div class="fitur-text">
                    <h4>Pengeluaran Operasional</h4>
                </div>
            </a>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST" id="formLogout">
    @csrf
    <button type="button" id="btnLogoutTrigger" class="logout-btn">
        <img src="{{ asset('images/keperluandashboard/logout.png') }}" alt="Logout">
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
</body>
<script src="{{ asset('js/logout.js') }}"></script>
</html>