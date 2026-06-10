<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Stok Produk - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stokgudang.css') }}">
</head>
<body>
    <div id="alertContainer" class="alert-fixed-container"></div>
    <header class="header-putih">
        <h1 class="header-title">Mengubah Stok Produk</h1>
        <div class="logo-box">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text" style="height: 20px; margin-right: 10px;">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo ST">
        </div>
    </header>

    <main class="main-hijau">
        <a href="{{ route('produk.staf') }}" class="btn-back-circle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>

        <div class="card-stok">
            <form id="formUbahStok" action="{{ route('produk.update', $produk->id_produk) }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="form-group" style="position: relative;">
                    <label>Stok <span>*</span></label>
                    <input type="number" id="inputStok" name="stok" class="form-input" value="{{ $produk->stok }}" required>
                    
                    <div id="tooltipAlert" class="custom-tooltip" style="display: none;">
                        <div class="tooltip-icon">!</div>
                        <span>Harap isi stok produk</span>
                    </div>
                </div>

                <button type="button" id="btnTriggerSimpan" class="btn-simpan-stok">SIMPAN PERUBAHAN</button>
            </form>
        </div>

    </main>

    <div id="modalKonfirmasi" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p class="modal-text">Yakin ingin menyimpan<br>perubahan?</p>
            <div class="modal-actions">
                <button type="button" id="btnYa" class="btn-ya">Ya</button>
                <button type="button" id="btnBatal" class="btn-batal">Batal</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/ubah-stok.js') }}"></script>
</body>
</html>