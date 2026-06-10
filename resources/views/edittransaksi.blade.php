<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Transaksi - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/edittransaksi.css') }}">
</head>
<body>

    <div class="header-top">
        <h1 class="header-title">Edit Data Transaksi</h1>
        <div class="logo-container">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
        </div>
    </div>

    <div class="content-wrapper">
        {{-- Tombol Kembali (Panah Kiri) --}}
        <a href="{{ route('transaksi.index') }}" class="btn-back-circle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>

        @if(session('error'))
            <div style="background: #ff4d4f; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST" id="formTransaksi">
                @csrf

                <div class="card-header">
                    <h2>Informasi Transaksi</h2>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Tanggal Transaksi <span>*</span></label>
                        <input type="date" name="tgl_transaksi" class="form-input" value="{{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Pembayaran <span>*</span></label>
                        <select name="status_bayar" class="form-input" required>
                            <option value="Tunai" {{ $transaksi->status_bayar == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="Bank Mandiri" {{ $transaksi->status_bayar == 'Bank Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                            <option value="Bank BCA" {{ $transaksi->status_bayar == 'Bank BCA' ? 'selected' : '' }}>Bank BCA</option>
                            <option value="Bank BRI" {{ $transaksi->status_bayar == 'Bank BRI' ? 'selected' : '' }}>Bank BRI</option>
                            <option value="Bank BNI" {{ $transaksi->status_bayar == 'Bank BNI' ? 'selected' : '' }}>Bank BNI</option>
                            <option value="Bank BSI" {{ $transaksi->status_bayar == 'Bank BSI' ? 'selected' : '' }}>Bank BSI</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipe Pelanggan <span>*</span></label>
                        <select name="tipe_pelanggan" class="form-input" required>
                            <option value="Kios" {{ $transaksi->tipe_pelanggan == 'Kios' ? 'selected' : '' }}>Kios</option>
                            <option value="Mitra" {{ $transaksi->tipe_pelanggan == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Pelanggan <span>*</span></label>
                        <input type="text" name="nama_pelanggan" class="form-input" value="{{ $transaksi->nama_pelanggan }}" placeholder="Contoh: Toko Jakik 2" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon <span>*</span></label>
                        <input type="text" name="no_telp" class="form-input" value="{{ $transaksi->no_telp }}" placeholder="Contoh: 08345..." required>
                    </div>
                </div>

                <div class="card-header">
                    <h2>Produk yang Dibeli</h2>
                    <button type="button" class="btn-tambah-produk" id="btnTambahRow">+ Tambah Produk</button>
                </div>

                <div id="produk-container">
                    @foreach($transaksi->detailTransaksi as $dtl)
                    <div class="produk-row">
                        <div class="form-group">
                            <label>Nama Produk <span>*</span></label>
                            <select name="produk[]" class="form-input select-produk" required>
                                <option value="" disabled>Pilih Produk...</option>
                                @foreach($produks as $p)
                                    <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga_jual }}" {{ $p->id_produk == $dtl->id_produk ? 'selected' : '' }}>
                                        {{ $p->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah <span>*</span></label>
                            <input type="number" name="jmlh_beli[]" class="form-input input-qty" min="1" value="{{ $dtl->jmlh_beli }}" required>
                        </div>
                        <div class="form-group">
                            <label>Subtotal (Rp)</label>
                            <input type="text" class="form-input input-subtotal-view" value="{{ number_format($dtl->subtotal, 0, ',', '.') }}" readonly style="background: #e2e8f0;">
                            <input type="hidden" name="harga_satuan[]" class="input-harga-satuan" value="{{ $dtl->harga_satuan }}">
                        </div>
                        <button type="button" class="btn-hapus-row" title="Hapus Produk">X</button>
                    </div>
                    @endforeach
                </div>

                <div class="total-section">
                    <div class="total-text">Total Bayar</div>
                    <div class="total-value" id="displayTotal">Rp. 0</div>
                    <input type="hidden" name="total_bayar_input" id="inputTotalBayar" value="0">

                    <div class="btn-action-group">
                        {{-- Tombol Batal udah dimusnahin! Sisa tombol Simpan aja --}}
                        <button type="button" class="btn-submit" onclick="bukaModalSimpan()">SIMPAN PERUBAHAN</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- ===================== MODAL KONFIRMASI SIMPAN ===================== --}}
    <div id="modalKonfirmasiSimpan"
         style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); z-index: 99999;
                justify-content: center; align-items: center;
                backdrop-filter: blur(2px);">
        <div style="background: white; border-radius: 20px; padding: 40px 50px;
                    box-shadow: 0 8px 30px rgba(0,0,0,0.2); text-align: center; max-width: 450px;">
            <p style="font-size: 18px; font-weight: 600; color: #111; margin: 0 0 30px 0; line-height: 1.5;">
                Yakin ingin menyimpan<br>perubahan?
            </p>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <button type="button" onclick="submitSimpan()"
                    style="background-color: #39ff14; color: black; border: none;
                           padding: 12px 40px; border-radius: 30px; cursor: pointer; font-weight: 700; font-size: 15px;">
                    Ya
                </button>
                <button type="button" onclick="tutupKonfirmasiSimpan()"
                    style="background-color: #ff0000; color: rgb(0, 0, 0); border: none;
                           padding: 12px 40px; border-radius: 30px; cursor: pointer; font-weight: 700; font-size: 15px;">
                    Batal
                </button>
            </div>
        </div>
    </div>

    {{-- TEMPLATE HTML BUAT JS --}}
    <template id="row-template">
        <div class="form-group">
            <label>Nama Produk <span>*</span></label>
            <select name="produk[]" class="form-input select-produk" required>
                <option value="" disabled selected>Pilih Produk...</option>
                @foreach($produks as $p)
                    <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga_jual }}">{{ $p->nama_produk }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jumlah <span>*</span></label>
            <input type="number" name="jmlh_beli[]" class="form-input input-qty" min="1" value="1" required>
        </div>
        <div class="form-group">
            <label>Subtotal (Rp)</label>
            <input type="text" class="form-input input-subtotal-view" value="0" readonly style="background: #e2e8f0;">
            <input type="hidden" name="harga_satuan[]" class="input-harga-satuan" value="0">
        </div>
        <button type="button" class="btn-hapus-row" title="Hapus Produk">X</button>
    </template>

    <script src="{{ asset('js/edittransaksi.js') }}?v={{ time() }}"></script>
</body>
</html>
