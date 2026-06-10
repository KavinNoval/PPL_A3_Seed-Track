<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Staf - Seed Track</title>
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

        <a href="{{ route('profil.perusahaan') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/profilperusahaan.png') }}" alt="Profil">
            </div>
            <div class="menu-text">Profil Perusahaan</div>
        </a>

        <a href="{{ route('data.staf') }}" class="menu-item active">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/datadata.png') }}" alt="Data Staf">
            </div>
            <div class="menu-text">Data Staf</div>
        </a>

        <a href="{{ route('data.mitra') }}" class="menu-item">
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

        <a href="{{route('produk.admin')}}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/katalogg.png') }}" alt="Katalog">
            </div>
            <div class="menu-text">Katalog Produk</div>
        </a>

        <a href="{{ route('monitoring.admin') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/monitoring.png') }}" alt="Monitoring">
            </div>
            <div class="menu-text">Monitoring Lahan</div>
        </a>

        <a href="{{ route('transaksi.index') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ asset('images/keperluandashboard/transaksi.png') }}" alt="Transaksi">
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

        <div id="modalLogout" class="modal-overlay" style="display: none;">
            <div class="modal-box">
                <p>Apakah anda yakin ingin<br>melakukan Log Out?</p>
                <div class="modal-buttons">
                    <button type="button" id="btnYaLogout" class="btn-modal btn-ya">Ya</button>
                    <button type="button" id="btnBatalLogout" class="btn-modal btn-batal">Batal</button>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
            <div class="page-header">
                <h1 class="page-title" style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 5px;">Data Staf</h1>
                <p class="page-description" style="font-size: 0.95rem; color: #64748b; margin-top: 0;">Kelola dan pantau semua akses staf operasional perusahaan.</p>
            </div>

            <div class="topbar-logo" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track" style="height: 35px;">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" style="height: 35px;">
            </div>
        </div>

        <header class="topbar-staf" style="margin-bottom: 25px;">
            <div class="top-action-bar">
                <input type="text" class="search-input" id="inputCariStaf" placeholder="Cari">
                <select id="filterDropdown" class="btn-filter" style="outline: none; cursor: pointer;">
                    <option value="semua">Semua (Filter)</option>
                    <optgroup label="Jabatan">
                        <option value="admin">Admin</option>
                        <option value="staff gudang">Staff Gudang</option>
                        <option value="staff lapang">Staff Lapang</option>
                    </optgroup>
                    <optgroup label="Status">
                        <option value="aktif">Status: Aktif</option>
                        <option value="non aktif">Status: Non Aktif</option>
                    </optgroup>
                </select>
            </div>
        </header>

        @if(session('success'))
            <div class="pesan-otomatis" style="background-color: #48bb78; padding: 12px 24px; border-radius: 8px; margin: 0 0 20px auto; width: fit-content; color: #ffffff; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #2f855a;">
                {{ session('success') }}
            </div>
        @endif

        <div class="staff-grid">
            @foreach($staf as $s)
            <div class="staff-card">
                <div class="staff-header">
                    <div class="staff-header-left">
                        <img src="{{ asset('images/keperluandashboard/gridadmin.png') }}" alt="Ikon Profil" style="width: 24px; height: 24px; object-fit: contain;">
                        {{ $s->role }}
                    </div>

                    <div class="staff-header-right">
                        <div class="staff-badge" @if(strtolower($s->status) == 'non aktif') style="background-color: #e53e3e; color: #ffffff;" @endif>{{ $s->status ?? 'Aktif' }}</div>
                        <a href="{{ route('editstaf', $s->id_akun) }}">
                            <img src="{{ asset('images/keperluandashboard/tabler_edit.png') }}" alt="Edit" style="width: 20px; height: 20px; object-fit: contain;">
                        </a>
                    </div>
                </div>
                <div class="staff-body">
                    <div>Username : {{ $s->username }}</div>
                    <div>Nama Lengkap : {{ $s->nama_lengkap }}</div>
                    <div>Nomor Telepon : {{ $s->no_telp }}</div>
                    <div>Password : {{ $s->password }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('tambahinstaf') }}" class="fab-add">+</a>
    </main>

    <script src="{{ asset('js/logout.js') }}"></script>
    <script src="{{ asset('js/notif.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>
