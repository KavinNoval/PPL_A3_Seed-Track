<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mitra - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<aside class="sidebar">
    <a href="{{ route('dashboard.admin') }}" class="menu-item">
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

    <a href="{{ route('data.staf') }}" class="menu-item">
        <div class="icon-circle">
            <img src="{{ asset('images/keperluandashboard/datadata.png') }}" alt="Data Staf">
        </div>
        <div class="menu-text">Data Staf</div>
    </a>

    <a href="{{ route('data.mitra') }}" class="menu-item active">
        <div class="icon-circle">
            <img src="{{ asset('images/keperluandashboard/datadata.png') }}" alt="Data Mitra">
        </div>
        <div class="menu-text">Data Mitra</div>
    </a>

    <a href="{{ route('data.kios') }}" class="menu-item">
        <div class="icon-circle">
            <img src="{{ asset('images/keperluandashboard/datadata.png') }}" alt="Data Kios">
        </div>
        <div class="menu-text">Data Kios</div>
    </a>

    <a href="#" class="menu-item">
        <div class="icon-circle">
            <img src="{{ asset('images/keperluandashboard/katalogg.png') }}" alt="Katalog">
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
</aside>

<main class="main-content">
    <header class="topbar-staf">
        <div class="top-action-bar">
            <input type="text" class="search-input" placeholder="Cari">
            <button class="btn-filter">Filter Y</button>
        </div>
        <div class="topbar-logo">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
        </div>
    </header>

    @if(session('success'))
            <div class="pesan-otomatis" style="background-color: #48bb78; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #ffffff; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #2f855a;">
                {{ session('success') }}
            </div>
        @endif
        
        @if(request('status') == 'batal')
            <div class="pesan-otomatis" style="background-color: #ff0000ff; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #744210; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #b7791f;">
                Data mitra batal diubah
            </div>
        @endif

        @if(request('status') == 'batal_tambah')
            <div class="pesan-otomatis" style="background-color: #ff0000ff; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #744210; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #b7791f;">
                Data mitra batal disimpan
            </div>
        @endif

    <div class="staff-grid">
        @foreach($mitra as $m)
        <div class="staff-card">
            <div class="staff-header">
                <div class="staff-header-left">
                    <img src="{{ asset('images/keperluandashboard/gridadmin.png') }}" alt="Ikon Profil" style="width: 24px; height: 24px; object-fit: contain;">
                    Mitra
                </div>
                <div class="staff-header-right">
                    <a href="{{ route('editmitra', $m->id_mitra) }}">
                        <img src="{{ asset('images/keperluandashboard/tabler_edit.png') }}" alt="Edit" style="width: 20px; height: 20px; object-fit: contain;">
                    </a>
                </div>
            </div>

            <div class="staff-body">
                <div class="staff-row">
                    <span class="staff-label">Nama Mitra :</span>
                    <span class="staff-value">{{ $m->nama_mitra ?? '-' }}</span>
                </div>
                <div class="staff-row">
                    <span class="staff-label">Nomor Telepon :</span>
                    <span class="staff-value">{{ $m->no_telp ?? '-' }}</span>
                </div>
                <div class="staff-row">
                    <span class="staff-label">Jalan Lahan :</span>
                    <span class="staff-value">{{ $m->jalan_lahan ?? '-' }}</span>
                </div>
                <div class="staff-row">
                    <span class="staff-label">Blok Sawah :</span>
                    <span class="staff-value">{{ $m->blok_sawah ?? '-' }}</span>
                </div>
                <div class="staff-row">
                    <span class="staff-label">Luas Lahan :</span>
                    <span class="staff-value">{{ $m->luas_lahan ?? '-' }}</span>
                </div>
                <div class="staff-row">
                    <span class="staff-label">Est. Jumlah Panen :</span>
                    <span class="staff-value">{{ $m->est_jmlh_panen ?? '-' }}</span>
                </div>
                <div class="staff-row">
                    <span class="staff-label">Est. Benih :</span>
                    <span class="staff-value">{{ $m->est_benih ?? '-' }}</span>
                </div>
                <div class="staff-row">
                    <span class="staff-label">Tanggal Bergabung :</span>
                    <span class="staff-value">{{ $m->tgl_bergabung ?? '-' }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <a href="{{ route('tambahinmitra') }}" class="fab-add">+</a>
</main>
<script src="{{ asset('js/logout.js') }}"></script>
<script src="{{ asset('js/notif.js') }}"></script>
</body>
</html>