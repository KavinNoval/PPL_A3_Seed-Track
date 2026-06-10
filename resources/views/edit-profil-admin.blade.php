<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Perusahaan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- MANGGIL FILE CSS EKSTERNAL --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit-profil-admin.css') }}">
</head>
<body style="background-color: #f1f5f9; display: flex; margin: 0; font-family: 'Inter', sans-serif;">

    {{-- TOAST NOTIFIKASI MERAH (ERROR/BATAL) --}}
    <div id="toastNotif" class="toast-custom"></div>

    <div class="sidebar">
        <a href="{{ route('dashboard.admin') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/dashboardlg.png') }}" alt="Dashboard"></div><div class="menu-text">Dashboard</div></a>
        <a href="{{ route('profil.perusahaan') }}" class="menu-item active"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/profilperusahaan.png') }}" alt="Profil"></div><div class="menu-text">Profil Perusahaan</div></a>
        <a href="{{ route('data.staf') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Staf"></div><div class="menu-text">Data Staf</div></a>
        <a href="{{ route('data.mitra') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Mitra"></div><div class="menu-text">Data Mitra</div></a>
        <a href="{{ route('data.kios') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/datadata.png') }}" alt="Kios"></div><div class="menu-text">Data Kios</div></a>
        <a href="{{route('produk.admin')}}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/katalogg.png') }}" alt="Katalog"></div><div class="menu-text">Katalog Produk</div></a>
        <a href="{{ route('monitoring.admin') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/monitoring.png') }}" alt="Monitoring"></div><div class="menu-text">Monitoring Lahan</div></a>
        <a href="{{ route('transaksi.index') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/transaksi.png') }}" alt="Transaksi"></div><div class="menu-text">Transaksi</div></a>
        <a href="{{ route('pengeluaran.index') }}" class="menu-item"><div class="icon-circle"><img src="{{ url('images/keperluandashboard/pengeluaran.png') }}" alt="Pengeluaran"></div><div class="menu-text">Pengeluaran</div></a>
        <form action="{{ route('logout') }}" method="POST" id="formLogout" class="logout-form">
            @csrf
            <button type="button" class="menu-item btn-logout" id="btnLogoutTrigger">
                <div class="icon-circle"><img src="{{ url('images/keperluandashboard/logout.png') }}" alt="Logout"></div>
                <div class="menu-text">Logout</div>
            </button>
        </form>
    </div>

    <div class="main-content" style="padding: 40px;">
        <h1 class="page-title">Profil Perusahaan</h1>

        <div class="edit-container">
            <form id="formEditProfil" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="edit-section">
                    <div class="section-label">LOGO PERUSAHAAN</div>
                    <div class="logo-upload-wrap">
                        <div class="logo-preview-circle">
                            <img id="previewImgLogo" src="{{ asset('images/Logo ST.png') }}" alt="Logo">
                        </div>
                        <div>
                            <h3 style="margin: 0 0 6px 0; font-size: 16px; color: #1e293b;">Logo Utama Perusahaan</h3>
                            <p style="margin: 0 0 16px 0; font-size: 13px; color: #64748b;">Gunakan file gambar high-resolution (min 512x512px). Format yang didukung: PNG, JPG, atau SVG.</p>

                            <input type="file" name="logo_perusahaan" id="uploadLogo" accept="image/*" style="display: none;">
                            <button type="button" class="btn-logo-ganti" id="btnUploadTrigger">Ganti Logo</button>
                            <button type="button" class="btn-logo-hapus">Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="edit-section">
                    <div class="section-label">INFORMASI DASAR</div>
                    <div class="form-group-edit">
                        <label>Nama Perusahaan</label>
                        <div class="input-with-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                            <input type="text" name="nama_perusahaan" class="wajib-isi" value="{{ $profil->nama_perusahaan ?? 'CV Harapan Tani Nusantara' }}">
                        </div>
                    </div>
                    <div class="form-group-edit" style="margin-bottom: 0;">
                        <label>Deskripsi Singkat</label>
                        <textarea name="deskripsi_singkat" class="wajib-isi" rows="3">{{ $profil->deskripsi ?? 'CV Harapan Tani Nusantara adalah perusahaan agrikultur yang berfokus pada inovasi distribusi benih berkualitas tinggi dan manajemen lahan berkelanjutan untuk mendukung kedaulatan pangan nasional.' }}</textarea>
                    </div>
                </div>

                <div class="grid-2-edit">
                    <div class="edit-section" style="margin-bottom: 0;">
                        <div class="section-label">VISI</div>
                        <div class="form-group-edit" style="margin-bottom: 0;">
                            <textarea name="visi" class="wajib-isi" rows="4">{{ $profil->visi ?? 'Menjadi mitra terpercaya dalam transformasi agrikultur digital yang berkelanjutan di Asia Tenggara.' }}</textarea>
                        </div>
                    </div>
                    <div class="edit-section" style="margin-bottom: 0;">
                        <div class="section-label">MISI</div>
                        <div class="form-group-edit" style="margin-bottom: 0;">
                            <textarea name="misi" class="wajib-isi" rows="4">{{ $profil->misi ?? 'Meningkatkan kesejahteraan petani melalui akses teknologi benih unggul dan optimasi rantai pasokan hasil tani.' }}</textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="edit-section">
                    <div class="section-label">INFORMASI KONTAK</div>
                    <div class="form-group-edit">
                        <label>Alamat Kantor</label>
                        <div class="input-with-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <input type="text" name="alamat" class="wajib-isi" value="{{ $profil->alamat_kantor ?? 'Jl. Agro Inovasi No. 12, Kawasan Industri Hijau, Jawa Timur' }}">
                        </div>
                    </div>
                    <div class="grid-2-edit">
                        <div class="form-group-edit" style="margin-bottom: 0;">
                            <label>Email Resmi</label>
                            <div class="input-with-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <input type="email" name="email" class="wajib-isi" value="{{ $profil->email_resmi ?? 'contact@harapantani.com' }}">
                            </div>
                        </div>
                        <div class="form-group-edit" style="margin-bottom: 0;">
                            <label>Nomor Telepon</label>
                            <div class="input-with-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <input type="text" name="telepon" class="wajib-isi" value="{{ $profil->no_telp ?? '+62 21 5566 7788' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="edit-section">
                    <div class="section-label">MEDIA SOSIAL <span class="badge-opsional">OPSIONAL</span></div>
                    <div class="grid-3-edit">
                        <div class="input-with-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e1306c" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            <input type="text" name="url_instagram" placeholder="https://instagram.com/..." value="{{ $profil->url_instagram ?? '' }}">
                        </div>
                        <div class="input-with-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ff0000" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33 2.78 2.78 0 0 0 1.94 2c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                            <input type="text" name="url_youtube" placeholder="https://youtube.com/..." value="{{ $profil->url_youtube ?? '' }}">
                        </div>
                        <div class="input-with-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                            <input type="text" name="url_tiktok" placeholder="TikTok URL" value="{{ $profil->url_tiktok ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="edit-footer">
                    <div class="status-simpan">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        Perubahan belum disimpan.
                    </div>
                    <div>
                        <a href="{{ route('profil.perusahaan') }}" style="text-decoration: none;">
                            <button type="button" class="btn-batal-outline">Batal</button>
                        </a>
                        <button type="button" class="btn-simpan-solid" id="btnSimpanProfil">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL KONFIRMASI SIMPAN (JS EKSTERNAL) --}}
    <div id="modalKonfirmasiSimpan" class="modal-overlay-custom">
        <div class="modal-box-konfirmasi">
            <h3 class="modal-title-konfirmasi">Yakin ingin menyimpan perubahan?</h3>
            <div class="modal-buttons-konfirmasi">
                <button type="button" class="btn-ya-konfirmasi" id="btnYaSimpan">Ya</button>
                <button type="button" class="btn-batal-konfirmasi" id="btnBatalSimpan">Batal</button>
            </div>
        </div>
    </div>

    {{-- MODAL LOGOUT BAWAAN --}}
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
    <script src="{{ asset('js/edit-profil-admin.js') }}?v={{ time() }}"></script>
</body>
</html>
