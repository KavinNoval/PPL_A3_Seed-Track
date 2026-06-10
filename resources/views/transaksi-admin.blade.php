<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/transaksi.css') }}?v={{ time() }}">
</head>
<body class="body-transaksi" style="display: flex; margin: 0; background-color: #f4f7f4; font-family: 'Inter', sans-serif;">

    <div class="sidebar">
        <a href="{{ route('dashboard.admin') }}" class="menu-item">
            <div class="icon-circle">
                <img src="{{ url('images/keperluandashboard/dashboardlg.png') }}" alt="Dashboard">
            </div>
            <div class="menu-text">Dashboard</div>
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

        <a href="{{ route('produk.admin') }}" class="menu-item">
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

        <a href="{{ route('transaksi.index') }}" class="menu-item active">
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

    <div class="main-content-transaksi">

        @if(session('success'))
            <div class="toast-alert toast-success show" id="toast-sukses">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => { document.getElementById('toast-sukses').classList.remove('show'); }, 3000);
            </script>
        @endif

        @if(session('error'))
            <div class="toast-alert toast-danger show" id="toast-error">
                {{ session('error') }}
            </div>
            <script>
                setTimeout(() => { document.getElementById('toast-error').classList.remove('show'); }, 3000);
            </script>
        @endif

        <div id="toast-js" class="toast-alert"></div>

        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
            <div class="page-header">
                <h1 class="page-title" style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 5px;">Data Transaksi</h1>
                <p class="page-description" style="font-size: 0.95rem; color: #64748b; margin-top: 0;">Kelola dan pantau semua riwayat transaksi penjualan perusahaan.</p>
            </div>

            <div class="topbar-logo" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track" style="height: 35px;">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" style="height: 35px;">
            </div>
        </div>

        <div class="topbar-transaksi" style="margin-bottom: 25px;">
            <div class="action-group" style="display: flex; gap: 15px; align-items: center;">
                <div class="search-pill">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Cari">
                </div>

                <select id="filterTipePelanggan" class="filter-pill"
                    style="cursor: pointer; padding-right: 30px; appearance: none;
                           background-image: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"%236b7280\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"6 9 12 15 18 9\"></polyline></svg>');
                           background-repeat: no-repeat; background-position: right 10px center; outline: none;">
                    <option value="">Semua Filter</option>
                    <option value="mitra">Mitra</option>
                    <option value="kios">Kios</option>
                </select>

                <button id="btnSortNama" title="Sortir A-Z"
                    style="cursor: pointer; background: white; border: 1px solid #e2e8f0; border-radius: 10px;
                           width: 42px; height: 42px; display: flex; justify-content: center; align-items: center;
                           color: #6b7280; outline: none; transition: 0.3s;"
                    onmouseover="this.style.backgroundColor='#f8fafc'"
                    onmouseout="this.style.backgroundColor='white'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                </button>
            </div>
        </div>

        <div class="card-table-transaksi">
            <table class="table-st">
                <thead>
                    <tr>
                        <th>TANGGAL TRANSAKSI</th>
                        <th>TIPE PELANGGAN</th>
                        <th>NAMA PELANGGAN</th>
                        <th>NOMOR TELEPON</th>
                        <th>TOTAL BAYAR</th>
                        <th style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                        @php
                            $listProduk = [];
                            foreach($t->detailTransaksi as $dtl) {
                                $listProduk[] = [
                                    'nama'     => $dtl->produk ? $dtl->produk->nama_produk : 'Produk Dihapus',
                                    'jumlah'   => $dtl->jmlh_beli,
                                    'subtotal' => $dtl->subtotal
                                ];
                            }

                            $noTelp = $t->pembeli->no_telp;
                            if (empty($noTelp) || $noTelp == '0') {
                                $telpTampil = '-';
                            } else {
                                $telpTampil = str_starts_with($noTelp, '8') ? '0' . $noTelp : $noTelp;
                            }
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->tgl_transaksi)->translatedFormat('d F Y') }}</td>
                            <td>{{ $t->tipe_pelanggan }}</td>
                            <td style="font-weight: 700; color: #1e293b;">{{ $t->pembeli->nama_mitra ?? $t->pembeli->nama_kios ?? 'Data Tidak Ditemukan' }}</td>
                            <td>{{ $telpTampil }}</td>
                            <td style="font-weight: 700; color: #2D3A2E;">Rp. {{ number_format($t->total_bayar, 0, ',', '.') }}</td>

                            <td style="text-align: center;">
                                <a href="javascript:void(0)"
                                   class="btn-detail-trigger btn-action-icon"
                                   title="Lihat Detail & Edit"
                                   data-id="{{ $t->id_transaksi }}"
                                   data-url="{{ route('hapus-transaksi', $t->id_transaksi) }}"
                                   data-urledit="{{ route('transaksi.edit', $t->id_transaksi) }}"
                                   data-tgl="{{ \Carbon\Carbon::parse($t->tgl_transaksi)->translatedFormat('d F Y') }}"
                                   data-tipe="{{ $t->tipe_pelanggan }}"
                                   data-nama="{{ $t->pembeli->nama_mitra ?? $t->pembeli->nama_kios ?? 'Data Tidak Ditemukan' }}"
                                   data-telp="{{ $telpTampil }}"
                                   data-produks='{{ json_encode($listProduk) }}'
                                   data-bayar="{{ $t->status_bayar ?? '-' }}"
                                   data-total="Rp. {{ number_format($t->total_bayar, 0, ',', '.') }}">

                                   <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                       <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                       <circle cx="12" cy="12" r="3"></circle>
                                   </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #64748b; padding: 40px 0; font-weight: 600;">
                                Belum ada data transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('tambah-transaksi') }}" class="fab-tambah">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </a>
    </div>

    {{-- ===================== MODAL DETAIL TRANSAKSI ===================== --}}
    <div id="modalDetail"
         style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.4); z-index: 9999;
                flex-direction: column;
                justify-content: center; align-items: center;
                backdrop-filter: blur(2px);">

        <div style="background: white; border-radius: 24px; padding: 35px;
                    width: 600px; max-width: 90%;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1);">

            <div id="viewDetail">
                <h3 style="margin-top: 0; font-size: 18px; font-weight: 700;">Detail Data Transaksi</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin: 20px 0;">
                    <div>
                        <label style="font-size: 12px; color: #64748b; font-weight: 600;">Tanggal Transaksi</label>
                        <input id="det_tgl" type="text" readonly
                            style="width: 100%; margin-top: 6px; padding: 10px 14px; border: 1px solid #e2e8f0;
                                   border-radius: 10px; font-size: 14px; background: #f8fafc; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; font-weight: 600;">Total Bayar</label>
                        <input id="det_total" type="text" readonly
                            style="width: 100%; margin-top: 6px; padding: 10px 14px; border: 1px solid #e2e8f0;
                                   border-radius: 10px; font-size: 14px; background: #f8fafc; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; font-weight: 600;">Tipe Pelanggan</label>
                        <input id="det_tipe" type="text" readonly
                            style="width: 100%; margin-top: 6px; padding: 10px 14px; border: 1px solid #e2e8f0;
                                   border-radius: 10px; font-size: 14px; background: #f8fafc; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; font-weight: 600;">Nama Pelanggan</label>
                        <input id="det_nama" type="text" readonly
                            style="width: 100%; margin-top: 6px; padding: 10px 14px; border: 1px solid #e2e8f0;
                                   border-radius: 10px; font-size: 14px; background: #f8fafc; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; font-weight: 600;">Nomor Telepon</label>
                        <input id="det_telp" type="text" readonly
                            style="width: 100%; margin-top: 6px; padding: 10px 14px; border: 1px solid #e2e8f0;
                                   border-radius: 10px; font-size: 14px; background: #f8fafc; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; font-weight: 600;">Status Bayar</label>
                        <input id="det_bayar" type="text" readonly
                            style="width: 100%; margin-top: 6px; padding: 10px 14px; border: 1px solid #e2e8f0;
                                   border-radius: 10px; font-size: 14px; background: #f8fafc; box-sizing: border-box;">
                    </div>
                </div>

                <div style="margin-top: 8px;">
                    <label style="font-size: 12px; color: #64748b; font-weight: 600;">Produk yang Dibeli</label>
                    <div id="det_list_produk"
                         style="margin-top: 10px; max-height: 180px; overflow-y: auto;
                                border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 14px;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 25px;">
                    {{-- TOMBOL EDIT KUNING --}}
                    <a id="btnEditTransaksiModal" href="#"
                       style="background: #f59e0b; color: white; padding: 12px 35px;
                              border-radius: 30px; border: none; cursor: pointer;
                              font-weight: 700; font-size: 14px; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                        EDIT
                    </a>
                </div>
            </div>

            <form id="formHapusTransaksi" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>

        <div style="margin-top: 16px; color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500; letter-spacing: 0.5px; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
            Tekan halaman kosong untuk kembali
        </div>

    </div>

    {{-- ===================== MODAL KONFIRMASI HAPUS ===================== --}}
    <div id="modalKonfirmasi"
         style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); z-index: 99999;
                justify-content: center; align-items: center;
                backdrop-filter: blur(2px);">
        <div style="background: white; border-radius: 20px; padding: 40px 50px;
                    box-shadow: 0 8px 30px rgba(0,0,0,0.2); text-align: center;">
            <p style="font-size: 18px; font-weight: 600; color: #111; margin: 0 0 30px 0;">
                Yakin ingin menghapus transaksi?
            </p>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <button type="button" onclick="submitHapus()"
                    style="background-color: #48FF00; color: black; border: none;
                           padding: 12px 40px; border-radius: 30px; cursor: pointer; font-weight: 700;">
                    Ya
                </button>
                <button type="button" onclick="batalHapus()"
                    style="background-color: #FF0000; color: black; border: none;
                           padding: 12px 40px; border-radius: 30px; cursor: pointer; font-weight: 700;">
                    Batal
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL LOGOUT ===================== --}}
    <div id="modalLogout"
         style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.4); z-index: 99999;
                justify-content: center; align-items: center;
                backdrop-filter: blur(2px);">
        <div style="background: white; border-radius: 24px; padding: 40px; width: 400px; max-width: 90%;
                    text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <p style="font-size: 18px; font-weight: 600; color: #111; margin-top: 0; margin-bottom: 30px; line-height: 1.5;">
                Apakah anda yakin ingin<br>melakukan Log Out?
            </p>
            <div style="display: flex; justify-content: center; gap: 20px;">
                <button type="button" id="btnYaLogout"
                    style="background-color: #48FF00; color: black; border: none; padding: 12px 40px;
                           border-radius: 30px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s;">
                    Ya
                </button>
                <button type="button" id="btnBatalLogout"
                    style="background-color: #FF0000; color: black; border: none; padding: 12px 40px;
                           border-radius: 30px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s;">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/logout.js') }}"></script>
    <script src="{{ asset('js/transaksi.js') }}?v={{ time() }}"></script>

</body>
</html>
