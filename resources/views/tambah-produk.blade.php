<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk - Seed Track</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/tambah-produk.css') }}">
</head>

<body class="body-clean-layout">

<div class="full-main-wrapper">

    <!-- HEADER -->
    <header class="header-produk">

        <h1 class="header-title">
            Membuat Data Produk
        </h1>

        <div class="topbar-logo">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo ST">
        </div>

        <div class="alert-fixed-container" id="alert-container-ubah"></div>

    </header>

    <!-- CONTENT -->
    <main class="content-produk-full">

        <!-- ALERT -->
        <div class="alert-fixed-container" id="alert-master-container">

            @if(session('success'))
                <div class="alert-3d alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('cancel') || session('error'))
                <div class="alert-3d alert-error">
                    {{ session('cancel') ?? session('error') }}
                </div>
            @endif

        </div>

        <!-- BACK -->
        <a href="{{ route('produk.admin') }}" class="btn-back-circle">

            <svg width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="white"
                 stroke-width="3"
                 stroke-linecap="round"
                 stroke-linejoin="round">

                <line x1="19" y1="12" x2="5" y2="12"></line>

                <polyline points="12 19 5 12 12 5"></polyline>

            </svg>

        </a>

        <!-- CARD -->
        <div class="card-form-produk">

            <form action="{{ route('produk.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="formProduk">

                @csrf

                <div class="grid-layout">

                    <!-- KOLOM KIRI -->
                    <div class="grid-col">

                        <div class="form-group">

                            <label>
                                Nama Produk <span class="red">*</span>
                            </label>

                            <input type="text"
                                   name="nama_produk"
                                   placeholder="Nama Produk"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>
                                Stok <span class="red">*</span>
                            </label>

                            <input type="number"
                                   name="stok"
                                   placeholder="Stok"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>
                                Deskripsi <span class="red">*</span>
                            </label>

                            <textarea name="deskripsi"
                                      placeholder="Masukkan text"
                                      required></textarea>

                        </div>

                    </div>

                    <!-- KOLOM KANAN -->
                    <div class="grid-col">

                        <div class="form-group">

                            <label>
                                Keunggulan <span class="red">*</span>
                            </label>

                            <textarea name="keunggulan"
                                      placeholder="Keunggulan"
                                      required
                                      class="textarea-keunggulan"></textarea>

                        </div>

                        <div class="form-group">

                            <label>
                                Harga Jual <span class="red">*</span>
                            </label>

                            <input type="text"
                                   name="harga_jual"
                                   placeholder="Harga Jual"
                                   required>

                        </div>

                        <!-- UPLOAD FOTO -->
                        <div class="form-group">

                            <label>
                                Upload Foto Produk <span class="red">*</span>
                            </label>

                            <label for="foto_produk" class="upload-box">

                                <!-- DEFAULT -->
                                <div class="upload-content"
                                     id="upload-preview-container">

                                    <svg id="upload-icon"
                                         width="28"
                                         height="28"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="#cbd5e1"
                                         stroke-width="2">

                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>

                                        <polyline points="7 10 12 15 17 10"></polyline>

                                        <line x1="12" y1="15" x2="12" y2="3"></line>

                                    </svg>

                                    <span id="file-name">
                                        Klik untuk upload foto
                                    </span>

                                </div>

                                <!-- PREVIEW -->
                                <img id="preview-foto-produk"
                                     src=""
                                     alt="Preview Foto">

                                <!-- INPUT -->
                                <input type="file"
                                       id="foto_produk"
                                       name="foto_produk"
                                       hidden
                                       accept="image/*"
                                       capture="environment"
                                       required>

                            </label>

                        </div>

                        <!-- BUTTON -->
                        <button type="button"
                                id="btnTriggerSimpan"
                                class="btn-simpan">

                            SIMPAN

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </main>

</div>

<!-- MODAL -->
<div id="modalKonfirmasi"
     class="modal-konfirmasi-overlay"
     style="display: none;">

    <div class="modal-konfirmasi-box">

        <p>
            Apakah ingin menambah produk?
        </p>

        <div class="modal-konfirmasi-buttons">

            <button type="button"
                    id="btnYaSimpan"
                    class="btn-konf btn-ya">

                Ya

            </button>

            <button type="button"
                    id="btnBatalSimpan"
                    class="btn-konf btn-batal"
                    data-pesan="Data produk batal disimpan">

                Batal
            </button>

        </div>

    </div>

</div>

<script src="{{ asset('js/tambah-produk.js') }}"></script>

</body>
</html>
