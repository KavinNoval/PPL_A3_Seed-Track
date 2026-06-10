<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Data Transaksi - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tambah-transaksi.css') }}">
</head>
<body>
    <div class="top-header">
        <h1 class="header-title">Membuat Data Transaksi</h1>
        <div class="logo-box">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo ST">
        </div>
    </div>

    <div class="main-container">

        @php
            $redirectUrl = (Auth::check() && in_array(Auth::user()->role, ['Staff Gudang', 'Staf Gudang']))
                           ? route('transaksi.staf')
                           : route('transaksi.index');
        @endphp
        <button type="button" id="btnBackTop" class="btn-back-circle" data-url="{{ $redirectUrl }}" style="border: none; cursor: pointer; display: flex; justify-content: center; align-items: center;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </button>

        @if(session('error') || $errors->any())
            <div class="toast-alert toast-danger show" id="toast-error">
                Data Kios/Mitra dengan nomor tersebut tidak ditemukan di database!
            </div>
            <script>
                setTimeout(() => { document.getElementById('toast-error').classList.remove('show'); }, 3000);
            </script>
        @endif

        <div class="toast-alert toast-danger" id="toast-batal">
            Data transaksi batal disimpan
        </div>

        <div class="card-form clearfix">

            <form action="{{ route('simpan-transaksi') }}" method="POST" id="formBuatTransaksi">
                @csrf

                <div id="step1_pelanggan">
                    <h3 class="card-title">Form Pelanggan</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tanggal Transaksi <span>*</span></label>
                            <input type="date" name="tgl_transaksi" id="inp_tgl" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe Pelanggan <span>*</span></label>
                            <div class="select-wrapper">
                                <select name="tipe_pelanggan" id="inp_tipe" class="form-input" required>
                                    <option value="" selected disabled>Masukkan Tipe Pelanggan</option>
                                    <option value="Mitra">Mitra</option>
                                    <option value="Kios">Kios</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Pelanggan <span>*</span></label>
                            <input type="text" name="nama_pelanggan" id="inp_nama" class="form-input" placeholder="Masukkan Nama Pelanggan" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon <span>*</span></label>
                            <input type="text" inputmode="numeric" name="nomor_telepon" id="inp_telp" class="form-input" placeholder="Masukkan Nomor Telepon" required>
                        </div>
                    </div>
                    <button type="button" class="btn-green-submit" id="btnLanjut">LANJUT</button>
                </div>

                <div id="step2_transaksi" style="display: none;">

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 class="card-title" style="margin: 0;">Form Transaksi</h3>

                        <button type="button" id="btn-tambah-produk" style="background: transparent; color: #A3B87A; border: 2px dashed #A3B87A; padding: 8px 15px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 13px;">
                            + Tambah Produk
                        </button>
                    </div>

                    <div id="wadah-semua-produk">
                        <div class="baris-produk" style="position: relative; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px dashed #cbd5e1;">
                            <div class="form-grid">

                                <div class="form-group">
                                    <label>Nama Produk <span>*</span></label>
                                    <div class="select-wrapper">
                                        <select name="produk[]" class="form-input pilih-produk" onchange="kalkulasiTotal()" required>
                                            <option value="" selected disabled>Masukkan Nama Produk</option>
                                            @foreach($produks as $p)
                                                <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga_jual }}" data-stok="{{ $p->stok }}">
                                                    {{ $p->nama_produk }} (Rp. {{ number_format($p->harga_jual, 0, ',', '.') }} | Stok: {{ $p->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Jumlah <span>*</span></label>
                                    <div style="display: flex; gap: 10px;">
                                        <input type="number" name="jmlh_beli[]" class="form-input input-jumlah" placeholder="Masukkan Jumlah" oninput="kalkulasiTotal()" required style="flex: 1;">

                                        <button type="button" class="btn-hapus-baris" style="display: none; width: 45px; border-radius: 8px; border: none; background: #ef4444; color: white; cursor: pointer; font-weight: bold; font-size: 16px;">X</button>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" name="harga_satuan[]" class="hidden_harga" value="0">
                            <input type="hidden" name="subtotal[]" class="hidden_subtotal" value="0">
                        </div>

                    </div>

                    <div class="form-grid" style="margin-top: 15px;">
                        <div class="form-group">
                            <label>Pembayaran <span>*</span></label>
                            <div class="select-wrapper">
                                <select name="status_bayar" id="inp_pembayaran" class="form-input" required>
                                    <option value="" selected disabled>Masukkan Metode Pembayaran</option>
                                    <option value="Tunai">Tunai</option>
                                    <option value="Bank Mandiri">Bank Mandiri</option>
                                    <option value="Bank BCA">Bank BCA</option>
                                    <option value="Bank BRI">Bank BRI</option>
                                    <option value="Bank BNI">Bank BNI</option>
                                    <option value="Bank BSI">Bank BSI</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Total Bayar</label>
                            <input type="text" id="display_total" class="form-input" value="Rp. 0" readonly style="background: #f8fafc; font-weight: 700; color: #64748b; pointer-events: none;">
                        </div>
                    </div>

                    <input type="hidden" name="total_tagihan" id="hidden_tagihan" value="0">
                    <input type="hidden" name="total_bayar" id="hidden_total_bayar" value="0">
                    <input type="hidden" name="jumlah_hutang" value="0">

                    <div style="margin-top: 30px; text-align: right;">
                        <button type="button" class="btn-green-submit" id="btnSimpan" style="padding: 12px 45px;">SIMPAN</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="modalSimpan" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p class="modal-text">Apakah ingin menambah<br>transaksi?</p>
            <div class="modal-buttons">
                <button type="button" id="btnYaSimpan" class="btn-ya">Ya</button>
                <button type="button" id="btnBatalSimpan" class="btn-batal">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/tambah-transaksi.js') }}?v={{ time() }}"></script>
</body>
</html>
