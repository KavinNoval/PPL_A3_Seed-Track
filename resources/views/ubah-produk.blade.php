<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Produk - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tambah-produk.css') }}?v={{ time() }}">
</head>
<body class="body-clean-layout">

    @php
        $isStaf = Auth::check() && (Auth::user()->role == 'Staff Gudang' || Auth::user()->role == 'Staf Gudang');
    @endphp

    <div class="full-main-wrapper">
        <header class="header-produk">
            <h1 class="header-title">Mengubah Data Produk</h1>
            <div class="topbar-logo">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo ST">
            </div>

            <div class="alert-fixed-container" id="alert-container-ubah">
            @if(session('success'))
                <div class="alert-3d alert-success">{{ session('success') }}</div>
            @endif
            @if(session('cancel') || session('error'))
                <div class="alert-3d alert-error">{{ session('cancel') ?? session('error') }}</div>
            @endif
            </div>
        </header>

        <main class="content-produk-full">
            <a href="{{ $isStaf ? route('produk.staf') : route('produk.admin') }}" class="btn-back-circle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>

            <div class="card-form-produk">
                <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" id="formProduk">
                    @csrf
                    @method('PUT')

                    <div class="grid-layout">
                        <div class="grid-col">
                            <div class="form-group">
                                <label>Nama Produk <span class="red">*</span></label>
                                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" placeholder="Nama Produk" {{ $isStaf ? 'readonly' : '' }} class="{{ $isStaf ? 'gembok-input' : '' }}" required>
                            </div>

                            <div class="form-group">
                                <label>Stok <span class="red">*</span></label>
                                <input type="number" name="stok" value="{{ $produk->stok }}" placeholder="Stok" required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi <span class="red">*</span></label>
                                <textarea name="deskripsi" placeholder="Masukkan text" {{ $isStaf ? 'readonly' : '' }} class="{{ $isStaf ? 'gembok-input' : '' }}" required>{{ $produk->deskripsi }}</textarea>
                            </div>
                        </div>

                        <div class="grid-col">
                            <div class="form-group">
                                <label>Keunggulan <span class="red">*</span></label>
                                <textarea name="keunggulan" placeholder="Keunggulan" required style="height: 130px;" {{ $isStaf ? 'readonly' : '' }} class="{{ $isStaf ? 'gembok-input' : '' }}">{{ $produk->keunggulan }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Harga Jual <span class="red">*</span></label>
                                <input type="text" name="harga_jual" value="{{ $produk->harga_jual }}" placeholder="Harga Jual" {{ $isStaf ? 'readonly' : '' }} class="{{ $isStaf ? 'gembok-input' : '' }}" required>
                            </div>

                            <div class="form-group">
                                <label>Upload Foto Produk <span class="red">*</span></label>

                                @if($isStaf)
                                    <div class="gembok-input" style="padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; text-align: center;">
                                        @if(!empty($produk->foto_produk))
                                            <img src="/foto_produk/{{ $produk->foto_produk }}" style="max-height: 80px; border-radius: 6px;" onerror="this.src='{{ asset('images/Logo ST.png') }}';">
                                        @else
                                            <span style="font-size: 13px;">Tidak ada foto</span>
                                        @endif
                                    </div>
                                @else
                                    <label for="foto_produk" class="upload-box" style="display: block; cursor: pointer; border: 2px dashed #cbd5e1; border-radius: 12px; overflow: hidden; position: relative; background: #f8fafc; height: 200px;">

                                        <div class="upload-content {{ $produk->foto_produk ? '' : 'has-preview' }}" id="upload-preview-container"
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: {{ $produk->foto_produk ? 'none' : 'flex' }}; flex-direction: column; align-items: center; width: 100%;">
                                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                            <span id="file-name" style="color: #64748b; font-size: 14px; margin-top: 10px;">Klik untuk ubah foto</span>
                                        </div>

                                        <img id="preview-foto-produk"
                                            src="{{ $produk->foto_produk ? '/foto_produk/' . $produk->foto_produk : '' }}"
                                            class="preview-image-style"
                                            style="display: {{ $produk->foto_produk ? 'block' : 'none' }}; width: 100%; height: 100%; object-fit: cover;"
                                            onerror="this.src='{{ asset('images/Logo ST.png') }}';">

                                        <input type="file" id="foto_produk" name="foto_produk" hidden accept="image/*">
                                    </label>
                                    <small style="color: #666; font-size: 0.75rem; margin-top: 5px; display: block;">*Kosongkan jika tidak ingin mengubah foto</small>
                                @endif
                            </div>

                            <button type="button" id="btnTriggerSimpan" class="btn-simpan">SIMPAN PERUBAHAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div id="modalKonfirmasi" class="modal-konfirmasi-overlay" style="display: none;">
        <div class="modal-konfirmasi-box">
            <p>Yakin ingin menyimpan perubahan?</p>
            <div class="modal-konfirmasi-buttons">
                <button type="button" id="btnYaSimpan" class="btn-konf btn-ya">Ya</button>
                <button type="button" id="btnBatalSimpan" class="btn-konf btn-batal" data-pesan="Data produk batal diubah">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/tambah-produk.js') }}?v={{ time() }}"></script>
</body>
</html>
