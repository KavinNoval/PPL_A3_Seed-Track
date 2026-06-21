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

        <a href="{{ route('data.kios') }}" class="menu-item">
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

        <div id="modalLogout" class="modal-overlay" style="display: none;">
            <div class="modal-box">
                <p>Apakah anda yakin ingin<br>melakukan Log Out?</p>
                <div class="modal-buttons">
                    <button type="button" id="btnYaLogout" class="btn-modal btn-ya">Ya</button>
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
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
            </div>
        </div>

        <div class="greeting" style="margin-bottom: 8px;">
            Halo {{ Auth::user()->nama_lengkap }}, Selamat Datang Kembali!
        </div>

        <p style="font-size: 0.95rem; color: #475569; max-width: 800px; line-height: 1.5; margin-bottom: 32px; font-weight: 500;">
            Mengoptimalkan pengelolaan stok dan pencatatan keuangan operasional untuk meningkatkan akurasi, keteraturan, dan pengendalian data operasional perusahaan.
        </p>

        {{-- ================= SEKSI 1: RINGKASAN UTAMA ================= --}}
        <div class="section-title">Laporan Utama</div>

        <div class="cards-grid">
            {{-- KARTU 1: TOTAL PENJUALAN --}}
            {{-- KARTU 1: TOTAL PENJUALAN (DENGAN FILTER) --}}
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <div class="card-title">Total Penjualan</div>
                        <div class="card-subtitle">{{ request('bulan') || request('tahun') ? 'Data Difilter' : 'Bulan Ini' }}</div>
                    </div>

                    {{-- Form Filter Otomatis Submit --}}
                    <form action="{{ route('dashboard.admin') }}" method="GET" style="display: flex; gap: 8px;">
                        <select name="bulan" onchange="this.form.submit()" style="padding: 4px 8px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.8rem; outline: none; cursor: pointer;">
                            <option value="">Semua Bulan</option>
                            <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>

                        <select name="tahun" onchange="this.form.submit()" style="padding: 4px 8px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.8rem; outline: none; cursor: pointer;">
                            <option value="">Semua Tahun</option>
                            @php $tahunSekarang = date('Y'); @endphp
                            @for($i = $tahunSekarang; $i >= $tahunSekarang - 3; $i--)
                                <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </form>
                </div>

                <div class="card-value">
                    Rp. {{ number_format($total_penjualan, 0, ',', '.') }}
                    <span class="card-trend {{ $trend_penjualan >= 0 ? 'trend-up' : 'trend-down' }}" style="{{ $trend_penjualan < 0 ? 'color: #dc2626;' : '' }}">
                        Penjualan {!! $trend_penjualan >= 0 ? '&uarr;' : '&darr;' !!} {{ number_format(abs($trend_penjualan), 1) }}%
                    </span>
                </div>
            </div>

            {{-- KARTU 2: TOTAL SISA STOK (Piutang Dihapus) --}}
            <div class="card">
                <div class="card-title">Total Sisa Stok</div>
                <div class="card-subtitle">Saat Ini</div>
                <div class="card-value">
                    {{ number_format($total_stok, 1, ',', '.') }} Ton
                </div>
            </div>
        </div>

        {{-- ================= SEKSI 2: REKAP PENGELUARAN & PERINGATAN ================= --}}
        <div class="section-title" style="margin-top: 40px;">Rekap Pengeluaran & Peringatan</div>

        <div class="cards-grid">

            {{-- KARTU: PENGELUARAN BULAN INI (Sudah natural, tanpa border merah) --}}
            <div class="card">
                <div class="card-title">Pengeluaran Bulan Ini</div>
                <div class="card-subtitle">Total Operasional, Distribusi, dll</div>
                <div class="card-value">
                    Rp. {{ number_format($total_pengeluaran, 0, ',', '.') }}
                </div>
            </div>

            {{-- KARTU: PERINGATAN STOK MENIPIS (Yang ini biarin beda warna buat peringatan darurat) --}}
            <button type="button" onclick="bukaModalKritis()" style="all: unset; display: block; width: 100%; cursor: pointer;">
                <div class="card" style="background-color: #fff1f2; border: 1px solid #fecdd3; transition: 0.3s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <div class="card-title" style="color: #be123c;">Peringatan Stok</div>
                    <div class="card-subtitle" style="color: #fb7185;">Stok di bawah 100 Kg</div>
                    <div class="card-value" style="color: #e11d48;">
                        {{ $jumlah_stok_menipis }} Produk
                        <span class="card-trend" style="color: #be123c; background: #ffe4e6; padding: 4px 8px; border-radius: 4px;">Butuh Perhatian!</span>
                    </div>
                </div>
            </button>

            {{-- KARTU: BIAYA DISTRIBUSI --}}
            <div class="card">
                <div class="card-title">Biaya Distribusi</div>
                <div class="card-subtitle">{{ $persenDistribusi }}% dari total pengeluaran</div>
                <div class="card-value">
                    Rp. {{ number_format($totalDistribusi, 0, ',', '.') }}
                </div>
            </div>

            {{-- KARTU: BIAYA OPERASIONAL --}}
            <div class="card">
                <div class="card-title">Biaya Operasional Kantor</div>
                <div class="card-subtitle">{{ $persenOperasional }}% dari total pengeluaran</div>
                <div class="card-value">
                    Rp. {{ number_format($totalOperasional, 0, ',', '.') }}
                </div>
            </div>

            {{-- KARTU: PEMBELIAN ASET --}}
            <div class="card">
                <div class="card-title">Biaya Pembelian Aset</div>
                <div class="card-subtitle">{{ $persenAset }}% dari total pengeluaran</div>
                <div class="card-value">
                    Rp. {{ number_format($totalAset, 0, ',', '.') }}
                </div>
            </div>

        </div>
    </div>
    {{-- MODAL PRODUK KRITIS --}}
    <div id="modalKritis" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background: white; padding: 40px; border-radius: 30px; width: 500px; max-height: 80vh; overflow-y: auto; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
        <h2 style="margin-top:0; color: #1e293b;">Stok Kritis!</h2>
        <p style="color: #64748b;">Produk berikut butuh perhatian segera:</p>

        <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
            @foreach($produkKritis as $p)
                <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #fff1f2; border-radius: 20px; border: 1px solid #fecdd3;">
                    {{-- Gambar Produk (Kalau ada) --}}
                    <div style="width: 60px; height: 60px; background: #eee; border-radius: 12px; flex-shrink: 0;"></div>

                    <div style="flex-grow: 1;">
                        <h4 style="margin: 0; color: #1e293b;">{{ $p->nama_produk }}</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: #e11d48; font-weight: 700;">
                            Sisa Stok: {{ $p->stok }} pcs
                        </p>
                    </div>

                    {{-- Tombol Ubah Produk ke halaman edit produk --}}
                    <a href="{{ route('produk.edit', $p->id_produk) }}"
                       style="padding: 8px 15px; background: #eab308; color: white; border-radius: 20px; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
                       Edit
                    </a>
                </div>
            @endforeach
        </div>

        <button onclick="tutupModalKritis()" style="margin-top:30px; width:100%; padding: 15px; background: #2D3A2E; color:white; border:none; border-radius:20px; cursor:pointer; font-weight: 700;">
            Tutup
        </button>
    </div>
</div>

<script>
    function bukaModalKritis() { document.getElementById('modalKritis').style.display = 'flex'; }
    function tutupModalKritis() { document.getElementById('modalKritis').style.display = 'none'; }
</script>
</body>
<script src="{{ asset('js/logout.js') }}"></script>

</html>
