<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran Gudang - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengeluaran-gudang.css') }}?v={{ time() }}">
</head>
<body class="body-pengeluaran">

    <div class="main-content main-content-gudang">

        {{-- TOAST NOTIFIKASI BERHASIL --}}
        @if(session('success'))
            <div class="toast-alert toast-success show" id="toast-sukses">{{ session('success') }}</div>
            <script>setTimeout(() => { document.getElementById('toast-sukses').classList.remove('show'); }, 3000);</script>
        @endif

        <div class="topbar-header">
            <a href="{{ route('dashboard.gudang') }}" class="btn-back" title="Kembali ke Dashboard">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <div class="logo-container">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track" style="height: 20px;">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" style="height: 35px; margin-left: 10px;">
            </div>
        </div>

        <div class="page-header-gudang">
            <h1>Daftar Pengeluaran</h1>
            <p>Kelola dan pantau semua pengeluaran operasional.</p>
        </div>

        <div class="table-card">
            <div class="filter-bar">
                <div class="filter-search">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="inputCari" placeholder="Cari...">
                </div>

                <select class="filter-select" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    <option value="Distribusi">Distribusi</option>
                    <option value="Operasional Kantor">Operasional Kantor</option>
                    <option value="Pembelian Aset">Pembelian Aset</option>
                </select>

                <select class="filter-select" id="filterBulan">
                    <option value="">Semua Bulan</option>
                    <option value="jan">Januari</option>
                    <option value="feb">Februari</option>
                    <option value="mar">Maret</option>
                    <option value="apr">April</option>
                    <option value="mei">Mei</option>
                    <option value="jun">Juni</option>
                    <option value="jul">Juli</option>
                    <option value="ags">Agustus</option>
                    <option value="sep">September</option>
                    <option value="okt">Oktober</option>
                    <option value="nov">November</option>
                    <option value="des">Desember</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table-pengeluaran">
                    <thead>
                        <tr>
                            <th>TANGGAL</th>
                            <th>NAMA PENGELUARAN</th>
                            <th>NOMINAL</th>
                            <th>DESKRIPSI</th>
                            <th class="text-center">BUKTI NOTA</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-pengeluaran">
                        @forelse($pengeluarans as $p)
                            <tr>
                                <td class="td-tanggal">{{ \Carbon\Carbon::parse($p->tgl_pengeluaran)->translatedFormat('d M Y') }}</td>
                                <td>
                                    <div class="nama-item">{{ $p->nama_pengeluaran }}</div>
                                    <div class="kategori-item">{{ $p->kategori }}</div>
                                </td>
                                <td class="nominal-item">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                <td>
                                    <div style="font-size: 0.9rem; color: #475569; max-width: 250px; white-space: normal; line-height: 1.4;">
                                        {{ $p->keterangan ?? '-' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($p->bukti_nota)
                                        <button class="btn-icon" title="Lihat Nota" onclick="lihatNota('{{ asset('foto_pengeluaran/' . $p->bukti_nota) }}')">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14 2 14 8 20 8"/>
                                                <line x1="16" y1="13" x2="8" y2="13"/>
                                                <line x1="16" y1="17" x2="8" y2="17"/>
                                                <polyline points="10 9 9 9 8 9"/>
                                            </svg>
                                        </button>
                                    @else
                                        <span class="strip-kosong">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="data-kosong">Belum ada data pengeluaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <button type="button" class="fab-tambah" title="Tambah Pengeluaran" onclick="bukaModalTambah()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </button>
    </div>

    {{-- MODAL TAMBAH PENGELUARAN --}}
    <div id="modalTambahPengeluaran" class="modal-overlay" style="display: none;">
        <div class="modal-box-tambah">
            <div class="modal-tambah-header">
                <div class="header-title-wrap">
                    <div class="icon-kotak-hijau"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></div>
                    <div>
                        <h3 style="margin:0; color:#1e293b; font-size:1.1rem; font-weight:700;">Tambah Pengeluaran</h3>
                        <p style="margin:0; color:#64748b; font-size:0.8rem; margin-top:2px;">Catat detail pengeluaran operasional baru</p>
                    </div>
                </div>
                <button type="button" class="btn-close-x" onclick="tutupModalTambah()">&times;</button>
            </div>
            <form id="formTambahPengeluaran" action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-tambah-body">
                    <div class="form-row-2">
                        <div class="form-group-tambah">
                            <label>TANGGAL PENGELUARAN <span style="color: #ef4444;">*</span></label>
                            <input type="date" name="tgl_pengeluaran" class="input-tambah" required>
                        </div>
                        <div class="form-group-tambah">
                            <label>KATEGORI <span style="color: #ef4444;">*</span></label>
                            <select name="id_akun" class="input-tambah" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="2">Distribusi</option>
                                <option value="1">Operasional Kantor</option>
                                <option value="3">Pembelian Aset</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-tambah">
                        <label>NAMA PENGELUARAN <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="nama_pengeluaran" class="input-tambah" placeholder="Contoh: Sewa Truk Logistik..." required>
                    </div>
                    <div class="form-group-tambah">
                        <label>NOMINAL (RP) <span style="color: #ef4444;">*</span></label>
                        <div class="input-rp-wrap">
                            <span class="rp-prefix">Rp</span>
                            <input type="number" name="nominal" class="input-tambah input-with-rp" placeholder="0" required>
                        </div>
                    </div>
                    <div class="form-group-tambah">
                        <label>DESKRIPSI <span style="color: #ef4444;">*</span></label>
                        <textarea name="keterangan" class="input-tambah" rows="3" placeholder="Tuliskan detail pengeluaran..." required></textarea>
                    </div>
                    <div class="form-group-tambah">
                        <label>UPLOAD BUKTI PEMBAYARAN</label>
                        <div class="upload-area" onclick="document.getElementById('upload_bukti_baru').click()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <div class="upload-text-main">Klik untuk upload atau drag file ke sini</div>
                            <div class="upload-text-sub">JPG, PNG atau PDF (Max. 5MB)</div>
                        </div>
                        <input type="file" id="upload_bukti_baru" name="bukti_nota" accept="image/*,.pdf" style="display: none;" onchange="window.sihirPreviewGambar(this)">
                        <p id="nama_file_pilih" style="display: none; font-size: 0.8rem; color: #16a34a; margin-top: 8px; font-weight: 600;"></p>
                        <div id="wadah_preview_gambar" style="display: none; margin-top: 12px; padding: 10px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; text-align: center;">
                            <img id="preview_gambar_tambah" src="" alt="Preview" style="max-width: 100%; max-height: 140px; object-fit: contain; border-radius: 6px;">
                        </div>
                    </div>
                </div>
                <div class="modal-tambah-footer">
                    <button type="button" id="btn-trigger-simpan" class="btn-simpan-hijau">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL LIHAT NOTA --}}
    <div id="modalLihatNota" class="modal-overlay" style="display: none;" onclick="tutupNota()">
        <div style="position: relative; max-width: 90%; max-height: 90vh; background: transparent; display: flex; flex-direction: column; align-items: center;" onclick="event.stopPropagation();">
            <button type="button" onclick="tutupNota()" style="position: absolute; top: -40px; right: 0; background: none; border: none; color: white; font-size: 2rem; cursor: pointer; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">&times;</button>
            <img id="gambarNotaBesar" src="" alt="Bukti Nota" style="max-width: 100%; max-height: 85vh; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); background: white;">
        </div>
    </div>

    {{-- MODAL KONFIRMASI SIMPAN --}}
    <div id="modalKonfirmasiSimpan" class="modal-overlay" style="display: none; z-index: 9999;">
        <div class="modal-box-konfirmasi">
            <p class="modal-text-konfirmasi">Apakah ingin<br>menambah pengeluaran?</p>
            <div class="modal-buttons-konfirmasi">
                <button type="button" id="btnYaSimpan" class="btn-konfirmasi-ya">Ya</button>
                <button type="button" id="btnBatalSimpan" class="btn-konfirmasi-batal">Batal</button>
            </div>
        </div>
    </div>

    {{-- File JS yang sama dipake di Admin --}}
    <script src="{{ asset('js/pengeluaran.js') }}?v={{ time() }}"></script>
</body>
</html>
