<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profil->nama_perusahaan ?? 'CV Harapan Tani Nusantara' }} - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Seed Track Logo">
            </a>
            <ul class="nav-links">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#visi-misi">Visi Misi</a></li>
                <li><a href="#keunggulan">Keunggulan</a></li>
                <li><a href="#profil">Profil</a></li>
                <li><a href="#katalog">Katalog</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            <a href="#kontak" class="btn-nav">Hubungi Kami</a>
        </div>
    </nav>

    <header id="beranda" class="hero" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('{{ asset('images/profil/landing.png') }}');">
        <div class="hero-content">
            <div class="badge-glass">✨ DIGITALIZING AGRICULTURE</div>
            <h1>Sistem Informasi Integrasi<br>Operasional Produksi dan<br>Pemasaran Benih Padi</h1>
            <p>{{ $profil->deskripsi ?? 'Transformasi digital terpadu untuk CV Harapan Tani Nusantara. Mengelola seluruh ekosistem benih padi dengan presisi tinggi.' }}</p>
            <div class="hero-buttons">
                <a href="#katalog" class="btn-primary-glass">Katalog Produk</a>
                <a href="#kontak" class="btn-outline-glass">Hubungi Kami</a>
            </div>
        </div>
    </header>

    <section id="visi-misi" class="visi-misi-section">
        <div class="section-header center">
            <h2>Visi & Misi</h2>
            <p>Landasan komitmen kami untuk memajukan pertanian Indonesia melalui kualitas dan inovasi.</p>
        </div>

        <div class="vm-grid-new">

            <div class="visi-card-new">
                <div class="icon-visi">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>
                <h3>Visi</h3>
                <p>{{ $profil->visi ?? 'Menjadi perusahaan pembenihan tanaman pangan yang peduli terhadap perkembangan pertanian di Indonesia.' }}</p>
            </div>

            <div class="visi-card-new">
                <div class="icon-visi">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h3>Misi Perusahaan</h3>
                <p style="white-space: pre-line;">{{ $profil->misi ?? 'Meningkatkan kesejahteraan petani melalui akses teknologi benih unggul dan optimasi rantai pasokan hasil tani.' }}</p>
            </div>

        </div>
    </section>

    <section id="keunggulan" class="keunggulan-section">
        <div class="keunggulan-container">
            <h2>KEUNGGULAN</h2>
            <p>Sebagai perusahaan pembenihan padi, kami ikut andil dalam memenuhi kebutuhan petani terhadap ketersediaan benih padi di Indonesia.</p>
            <p>Kami juga menyediakan benih padi yang berkualitas dan unggul, berikut beberapa keunggulan pada perusahaan kami.</p>

            <ul class="keunggulan-list">
                <li>
                    <div class="hexagon-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#cc0000" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L21.5 7.5v11L12 24l-9.5-5.5v-11L12 2z"/></svg>
                    </div>
                    <span>Pada tahun 2023 kami memproduksi benih padi sebanyak 1300 Ton.</span>
                </li>
                <li>
                    <div class="hexagon-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#cc0000" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L21.5 7.5v11L12 24l-9.5-5.5v-11L12 2z"/></svg>
                    </div>
                    <span>Sistem produksi kami yaitu tanam sendiri dan bermitra dengan Petani.</span>
                </li>
                <li>
                    <div class="hexagon-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#cc0000" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L21.5 7.5v11L12 24l-9.5-5.5v-11L12 2z"/></svg>
                    </div>
                    <span>Luas lahan yang kami produksi tahun 2023 sebanyak 150 Hektare.</span>
                </li>
                <li>
                    <div class="hexagon-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#cc0000" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L21.5 7.5v11L12 24l-9.5-5.5v-11L12 2z"/></svg>
                    </div>
                    <span>Wilayah penyebaran benih yang kami produksi meliputi daerah Jember, Bondowoso, Probolinggo, Situbondo, Banyuwangi, Ngawi, Bojonegoro, Lamongan Dll.</span>
                </li>
            </ul>
        </div>
    </section>

    <section id="profil" class="profil-section">
        <div class="profil-container">
            <div class="profil-image-wrapper">
                <img src="{{ asset('images/profil/foto.jpg') }}" alt="Tim CV Harapan Tani" class="img-fluid">
                <div class="stat-overlap">
                    <div class="stat-item"><h2>500+</h2><p>MITRA PETANI</p></div>
                    <div class="divider"></div>
                    <div class="stat-item"><h2>25</h2><p>KIOS RESMI</p></div>
                </div>
            </div>
            <div class="profil-content">
                <span class="subtitle">TENTANG KAMI</span>
                <h2>{{ $profil->nama_perusahaan ?? 'CV Harapan Tani Nusantara' }}</h2>
                <p>Perusahaan yang bergerak di bidang perbenihan komoditas padi yang didirikan pada tanggal 12 November 2006 dan beroperasi di Kecamatan Kaliwates, Kabupaten Jember, Provinsi Jawa Timur.</p>
                <div class="profil-stats">
                    <div><h3>1</h3><p>Provinsi Distribusi</p></div>
                    <div><h3>100%</h3><p>Sertifikasi Legal</p></div>
                </div>
            </div>
        </div>
    </section>

    <section id="katalog" class="katalog-section">
        <div class="katalog-header">
            <div>
                <h2>Katalog Produk Benih</h2>
                <p>Varietas unggul pilihan untuk hasil panen yang melimpah.</p>
            </div>
            <div class="katalog-filters">
                <button class="filter-btn active">Semua</button>
            </div>
        </div>
        <div class="produk-grid">
            @forelse($produks as $p)
                <div class="produk-card" style="cursor: pointer;"
                     onclick="bukaModalProduk(this)"
                     data-nama="Varietas {{ $p->nama_produk }}"
                     data-harga="Rp {{ number_format($p->harga_jual, 0, ',', '.') }}/pcs"
                     data-stok="{{ $p->stok }} pcs"
                     data-foto="{{ asset('foto_produk/' . $p->foto_produk) }}"
                     data-deskripsi="{{ $p->deskripsi ?? 'Gabah premium dengan bibit kualitas terbaik untuk hasil panen maksimal.' }}">

                    <div class="produk-img-wrapper">
                        @if($p->stok > 10) <span class="badge-stok">STOK TERSEDIA</span>
                        @elseif($p->stok > 0) <span class="badge-terbatas">STOK TERBATAS</span>
                        @else <span class="badge-terbatas" style="background: #64748b;">STOK HABIS</span> @endif
                        <img src="{{ asset('foto_produk/' . $p->foto_produk) }}" alt="{{ $p->nama_produk }}" onerror="this.src='{{ asset('images/Logo ST.png') }}';">
                    </div>
                    <div class="produk-info">
                        <h4>Varietas {{ $p->nama_produk }}</h4>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                            <span style="font-weight: 800; color: #2D3A2E; font-size: 15px;">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}/pcs</span>
                            <span style="font-size: 12px; color: #64748b; font-weight: 600;">Stok: {{ $p->stok }} pcs</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 4; text-align: center; color: #64748b; padding: 40px 0; font-weight: 600;">
                    Belum ada produk benih yang tersedia saat ini.
                </div>
            @endforelse
        </div>
    </section>

    <div id="modalDetailProduk" class="modal-overlay" style="display: none; flex-direction: column; align-items: center; justify-content: center; z-index: 9999;">
        <div class="modal-produk-box">
            <div class="modal-produk-content">
                <div class="modal-produk-img">
                    <img id="detailFoto" src="" alt="Foto Produk">
                </div>
                <div class="modal-produk-info">
                    <h2 id="detailNama">Nama Produk</h2>

                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <span class="badge-stok-kuning">Stok</span>
                        <span id="detailStok" style="font-weight: 800; color: #1e293b; font-size: 15px;">0 pcs</span>
                    </div>

                    <p id="detailDeskripsi" class="desc-text">Deskripsi produk...</p>
                    <h3 id="detailHarga" class="price-text">Rp 0/Pcs</h3>

                    <div class="keunggulan-section">
                        <h4>Keunggulan</h4>
                        <ul>
                            <li>Tersortir dengan baik</li>
                            <li>Kemasan premium</li>
                        </ul>
                    </div>

                    <button onclick="tutupModalProduk()" class="btn-kuning-tutup">Tutup Detail</button>
                </div>
            </div>
        </div>
        <p class="modal-help-text">Tekan halaman kosong untuk kembali</p>
    </div>

    <section class="cta-whatsapp-section">
        <div class="cta-content">
            <h2>Mau Membeli Produk?</h2>
            <p>Staf kami siap melayani pembelian varietas padi<br>hingga seluruh provinsi jawa timur.</p>
            <div class="jam-operasional">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                JAM OPERASIONAL: 08:00 - 17:00 WIB
            </div>
        </div>
        <div class="cta-action">
            <a href="https://wa.me/6281234567890" target="_blank" class="btn-whatsapp">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                WhatsApp Sekarang
            </a>
        </div>
    </section>

    <footer id="kontak" class="footer">
        <div class="footer-grid">
            <div class="footer-col about">
                <div class="footer-logo-wrap">
                    <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" class="footer-logo-img">
                    <span class="footer-logo-text">SEED-TRACK</span>
                </div>
                <p>Platform digital terintegrasi untuk {{ $profil->nama_perusahaan ?? 'CV Harapan Tani Nusantara' }}. Melayani negeri dengan benih berkualitas sejak 2016.</p>
            </div>

            <div class="footer-col links">
                <h4>TAUTAN CEPAT</h4>
                <ul>
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#visi-misi">Visi Misi</a></li>
                    <li><a href="#profil">Profil Perusahaan</a></li>
                    <li><a href="#katalog">Katalog Produk</a></li>
                </ul>
            </div>

            <div class="footer-col contact">
                <h4>KONTAK KAMI</h4>
                <ul>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>{{ $profil->alamat_kantor ?? 'Jl. Tawas No 308, Kaliwates, Jember, Jawa Timur, 68131' }}</span>
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span>{{ $profil->no_telp ?? '+62 812-3456-7890' }}</span>
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span>{{ $profil->email_resmi ?? 'info@seedtrack-htn.com' }}</span>
                    </li>
                </ul>
            </div>

            <div class="footer-col social">
                <h4>MEDIA SOSIAL</h4>
                <div class="social-icons">
                    <a href="{{ $profil->url_instagram ?? '#' }}" target="_blank" class="soc-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="{{ $profil->url_youtube ?? '#' }}" target="_blank" class="soc-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33 2.78 2.78 0 0 0 1.94 2c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                    </a>
                    <a href="{{ $profil->url_tiktok ?? '#' }}" target="_blank" class="soc-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 SEED-TRACK — {{ $profil->nama_perusahaan ?? 'CV Harapan Tani Nusantara' }}. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
