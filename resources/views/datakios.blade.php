<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kios - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('dashboard.admin') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/dashboardlg.png') }}" alt="Dashboard">
            </div>
            <div class="menu-text">
                Dashboard
                <small>Laporan & Monitoring</small>
            </div>
        </a>

        <a href="{{ route('profil.perusahaan') }}" class="menu-item">
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

        <a href="{{ route('data.kios') }}" class="menu-item active">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Kios">
            </div>
            <div class="menu-text">Data Kios</div>
        </a>

        <a href="{{route('produk.admin')}}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/katalogg.png') }}" alt="Katalog">
            </div>
            <div class="menu-text">Katalog Produk</div>
        </a>

        <a href="{{ route('monitoring.admin') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/monitoring.png') }}" alt="Monitoring">
            </div>
            <div class="menu-text">Monitoring Lahan</div>
        </a>

        <a href="{{ route('transaksi.index') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/transaksi.png') }}" alt="Transaksi">
            </div>
            <div class="menu-text">Transaksi</div>
        </a>

        <a href="{{ route('pengeluaran.index') }}" class="menu-item">
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
    </div>

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div class="page-header">
            <h1 class="page-title" style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 5px;">Data Kios</h1>
            <p class="page-description" style="font-size: 0.95rem; color: #64748b; margin-top: 0;">Kelola dan pantau data kios penyalur yang bekerjasama dengan perusahaan.</p>
        </div>

        <div class="topbar-logo" style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track" style="height: 35px;">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" style="height: 35px;">
        </div>
    </div>
        <header class="topbar-staf">
            <div class="top-action-bar">
                <input type="text" class="search-input" id="inputCariStaf" placeholder="Cari">
                <select id="filterDropdown" class="btn-filter" style="outline: none; cursor: pointer;">
                    <option value="semua">Semua (Filter)</option>
                    <option value="ada_nib">Ada NIB</option>
                    <option value="tanpa_nib">Tanpa NIB</option>
                </select>
            </div>
        </header>

        @if(session('success'))
            <div class="pesan-otomatis" style="background-color: #48bb78; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #ffffff; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #2f855a;">
                {{ session('success') }}
            </div>
        @endif

        <div class="staff-grid">
            @foreach($kios as $k)
            <div class="staff-card">
                <div class="staff-header">
                    <div class="staff-header-left">
                        <img src="{{ asset('images/keperluandashboard/gridadmin.png') }}" alt="Ikon Kios" style="width: 24px; height: 24px; object-fit: contain;">
                        Kios
                    </div>
                    <div class="staff-header-right">
                        <a href="{{ route('editkios', $k->id_kios) }}">
                            <img src="{{ asset('images/keperluandashboard/tabler_edit.png') }}" alt="Edit" style="width: 20px; height: 20px; object-fit: contain;">
                        </a>
                    </div>
                </div>
                <div class="staff-body">
                    <div>Nama Kios : {{ $k->nama_kios ?? '-' }}</div>
                    <div>Nama Pemilik : {{ $k->nama_pemilik ?? '-' }}</div>
                    <div>Nomor Telepon : {{ $k->no_telp ?? '-' }}</div>
                    <div>Kabupaten : {{ $k->kabupaten ?? 'Belum diisi' }}</div>
                    <div>Kecamatan : {{ $k->kecamatan ?? 'Belum diisi' }}</div>
                    <div>Kelurahan / Desa : {{ $k->kelurahan ?? 'Belum diisi' }}</div>
                    <div>Alamat Kios : {{ $k->alamat_kios ?? '-' }}</div>
                    <div>NIB : {{ $k->NIB ?? '-' }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('tambahinkios') }}" class="fab-add">+</a>
    </main>

    <div id="modalLogout" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Apakah anda yakin ingin<br>melakukan Log Out?</p>
            <div class="modal-buttons">
                <button type="button" id="btnYaLogout" class="btn-modal btn-ya">Ya</button>
                <button type="button" id="btnBatalLogout" class="btn-modal btn-batal">Batal</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/logout.js') }}"></script>
    <script src="{{ asset('js/notif.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>
