<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- MANGGIL FILE CSS EKSTERNAL --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profil-admin.css') }}">
</head>
<body style="background-color: #f1f5f9; display: flex; margin: 0; font-family: 'Inter', sans-serif;">

    {{-- MARKER SESSION DARI CONTROLLER (BUAT DIBACA SAMA JS EKSTERNAL) --}}
    @if(session('success'))
        <div id="sessionSuccessMarker" data-message="Data profil perusahaan berhasil diubah" style="display: none;"></div>
    @endif

    {{-- TOAST NOTIFIKASI HIJAU (SUKSES) --}}
    <div id="toastSukses" class="toast-sukses-custom"></div>

    <div class="sidebar">
        <a href="{{ route('dashboard.admin') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/dashboardlg.png') }}" alt="Dashboard"></div><div class="menu-text">Dashboard<small>Laporan & Monitoring</small></div></a>
        <a href="{{ route('profil.perusahaan') }}" class="menu-item active"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/profilperusahaan.png') }}" alt="Profil"></div><div class="menu-text">Profil Perusahaan</div></a>
        <a href="{{ route('data.staf') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Staf"></div><div class="menu-text">Data Staf</div></a>
        <a href="{{ route('data.mitra') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Mitra"></div><div class="menu-text">Data Mitra</div></a>
        <a href="{{ route('data.kios') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Kios"></div><div class="menu-text">Data Kios</div></a>
        <a href="{{route('produk.admin')}}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/katalogg.png') }}" alt="Katalog"></div><div class="menu-text">Katalog Produk</div></a>
        <a href="{{ route('monitoring.admin') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/monitoring.png') }}" alt="Monitoring"></div><div class="menu-text">Monitoring Lahan</div></a>
        <a href="{{ route('transaksi.index') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/transaksi.png') }}" alt="Transaksi"></div><div class="menu-text">Transaksi</div></a>
        <a href="{{ route('pengeluaran.index') }}" class="menu-item"><div class="icon-circle"><img src="{ url('images/keperluandashboard/pengeluaran.png') }}" alt="Pengeluaran"></div><div class="menu-text">Pengeluaran</div></a>
        <form action="{{ route('logout') }}" method="POST" id="formLogout" class="logout-form">
            @csrf
            <button type="button" class="menu-item btn-logout" id="btnLogoutTrigger">
                <div class="icon-circle"><img src="{{ url('images/keperluandashboard/logout.png') }}" alt="Logout"></div><div class="menu-text">Logout</div>
            </button>
        </form>
    </div>

    <div class="main-content" style="padding: 40px; display: flex; flex-direction: column; align-items: center;">

        <div class="profil-wrapper" style="width: 100%; max-width: 1000px;">

            <div class="profil-header-card">
                <div class="profil-logo-box">
                    <img src="{{ asset('images/Logo ST.png') }}" alt="Logo HTN">
                </div>
                <div>
                    <span class="profil-badge">Didirikan Pada Tahun 2006</span>
                    <h1 class="profil-title">{{ $profil->nama_perusahaan ?? 'CV Harapan Tani Nusantara' }}</h1>
                    <p class="profil-desc">
                        {{ $profil->deskripsi ?? 'Pionir solusi teknologi pertanian modern di Indonesia yang mengintegrasikan data presisi, analisis lahan cerdas, dan manajemen rantai pasok benih untuk memberdayakan petani lokal.' }}
                    </p>

                    <a href="{{ route('profil.edit') }}" style="text-decoration: none;">
                        <button class="btn-edit-profil">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            Edit Profil
                        </button>
                    </a>
                </div>
            </div>

            <div class="grid-2">
                <div class="card-putih">
                    <div class="icon-bulat">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2D3A2E" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </div>
                    <h3>Visi Perusahaan</h3>
                    <p>{{ $profil->visi ?? 'Menjadi perusahaan teknologi agrikultur terdepan di Asia Tenggara yang menghubungkan kearifan lokal dengan inovasi digital untuk kedaulatan pangan berkelanjutan.' }}</p>
                </div>

                <div class="card-putih">
                    <div class="icon-bulat">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2D3A2E" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <h3>Misi Perusahaan</h3>
                    <p style="white-space: pre-line;">{{ $profil->misi ?? "✔ Mendigitalisasi ekosistem pertanian tradisional menjadi modern.\n✔ Menyediakan benih berkualitas tinggi dengan dukungan data analitik.\n✔ Meningkatkan transparansi dan efisiensi operasional bagi mitra tani." }}</p>
                </div>
            </div>

            <div class="grid-4">
                <div class="card-putih">
                    <div class="info-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Alamat Kantor
                    </div>
                    <div class="info-value">{{ $profil->alamat_kantor ?? 'Jl. Tawas No. 308, Kaliwates, Jember, Jawa Timur' }}</div>
                </div>

                <div class="card-putih">
                    <div class="info-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        Email Resmi
                    </div>
                    <div class="info-value">{{ $profil->email_resmi ?? 'contact@harapantani.co.id' }}</div>
                </div>

                <div class="card-putih">
                    <div class="info-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        Nomor Telepon
                    </div>
                    <div class="info-value">{{ $profil->no_telp ?? '+62 (24) 8877-2211' }}</div>
                </div>

                <div class="card-putih">
                    <div class="info-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        Pembaruan Terakhir
                    </div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($profil->updated_at ?? now())->translatedFormat('d M Y') }}</div>
                </div>
            </div>

            <h3 style="color: #2D3A2E; margin: 30px 0 0 0; font-size: 18px;">Media Sosial</h3>
            <div class="grid-3">
                <a href="{{ $profil->url_instagram ?? '#' }}" target="_blank" class="sosmed-card" style="text-decoration: none;">
                    <div class="sosmed-icon" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </div>
                    <div>
                        <div style="color: #0f172a; font-weight: 700; font-size: 14px;">Instagram</div>
                        <div style="color: #64748b; font-size: 12px; margin-top: 2px;">Klik untuk membuka</div>
                    </div>
                </a>

                <a href="{{ $profil->url_youtube ?? '#' }}" target="_blank" class="sosmed-card" style="text-decoration: none;">
                    <div class="sosmed-icon" style="background: #FF0000;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33 2.78 2.78 0 0 0 1.94 2c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                    </div>
                    <div>
                        <div style="color: #0f172a; font-weight: 700; font-size: 14px;">YouTube</div>
                        <div style="color: #64748b; font-size: 12px; margin-top: 2px;">Klik untuk membuka</div>
                    </div>
                </a>

                <a href="{{ $profil->url_tiktok ?? '#' }}" target="_blank" class="sosmed-card" style="text-decoration: none;">
                    <div class="sosmed-icon" style="background: black;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                    </div>
                    <div>
                        <div style="color: #0f172a; font-weight: 700; font-size: 14px;">TikTok</div>
                        <div style="color: #64748b; font-size: 12px; margin-top: 2px;">Klik untuk membuka</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div id="modalLogout" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Apakah anda yakin ingin<br>melakukan Log Out?</p>
            <div class="modal-buttons">
                <button type="button" id="btnYaLogout" class="btn-modal btn-ya">Ya</button>
                <button type="button" id="btnBatalLogout" class="btn-modal btn-batal">Batal</button>
            </div>
        </div>
    </div>

    {{-- MANGGIL FILE JS EKSTERNAL --}}
    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/profil-admin.js') }}?v={{ time() }}"></script>
</body>
</html>
