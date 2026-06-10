<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Staf Gudang Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ url('css/produk-admin.css') }}">
</head>
<body class="tanpa-sidebar" style="background-color: #f4f7f4; font-family: 'Inter', sans-serif;">

    <div class="content-wrapper-gudang">

        <div class="alert-fixed-container">
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

        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
            <div style="display: flex; align-items: flex-start; gap: 20px;">
                <a href="{{ route('dashboard.gudang') }}" class="btn-back-circle" style="margin-top: 3px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <div class="page-header">
                    <h1 class="page-title" style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 5px;">Katalog Produk</h1>
                    <p class="page-description" style="font-size: 0.95rem; color: #64748b; margin-top: 0;">Kelola daftar produk dan pantau ketersediaan stok di gudang.</p>
                </div>
            </div>

            <div class="topbar-logo" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track" style="height: 35px;">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" style="height: 35px;">
            </div>
        </div>

        <div class="topbar-produk" style="margin-bottom: 25px;">
            <div class="search-pill" style="display: flex; align-items: center; width: 350px; background: white; padding: 12px 20px; border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" placeholder="Cari Produk..." class="search-input" style="border: none; outline: none; background: transparent; width: 100%; margin-left: 10px; font-size: 0.95rem;">
            </div>
        </div>

        <div class="produk-grid" style="margin-top: 20px;">
            @forelse($produk as $item)

                <div class="produk-card btn-show-detail"
                     style="cursor: pointer; transition: transform 0.2s; display: flex; flex-direction: column; height: 100%;"
                     onmouseover="this.style.transform='scale(1.02)'"
                     onmouseout="this.style.transform='scale(1)'"
                     data-id="{{ $item->id_produk }}"
                     data-nama="{{ $item->nama_produk }}"
                     data-stok="{{ $item->stok }}"
                     data-deskripsi="{{ $item->deskripsi }}"
                     data-keunggulan="{{ $item->keunggulan }}"
                     data-harga="{{ number_format($item->harga_jual, 0, ',', '.') }}"
                     data-foto="/foto_produk/{{ $item->foto_produk }}">

                    <img src="/foto_produk/{{ $item->foto_produk }}"
                         alt="{{ $item->nama_produk }}"
                         class="produk-img"
                         style="object-fit: cover; width: 100%; height: 180px; background-color: #f8f9fa; border-radius: 20px 20px 0 0;"
                         onerror="this.onerror=null; this.src='/images/Logo ST.png'; this.style.objectFit='contain'; this.style.padding='20px';">

                    <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <h3 class="card-title" style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #2D3A2E;">{{ $item->nama_produk }}</h3>
                            <div class="badge-status" style="border: 1px solid #A7B774; color: #A7B774; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Tersedia</div>
                        </div>

                        <p class="card-desc" style="font-size: 0.85rem; color: #444; line-height: 1.6; margin-bottom: 20px;">
                            {{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}
                            <span style="color: #A7B774; font-weight: 600;">More in Detail</span>
                        </p>

                        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                            <div class="harga" style="font-weight: 800; color: #2D3A2E;">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}/Pcs</div>
                            <span class="btn-detail" style="background-color: #2D3A2E; color: white; padding: 8px 20px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">Detail</span>
                        </div>
                    </div>
                </div>

            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 100px 0; color: #888;">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" style="margin-bottom: 15px;"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    <p style="font-size: 1.2rem; font-weight: 700; color: #333;">Belum ada data produk</p>
                </div>
            @endforelse
        </div>
    </div>

    <div id="modalDetail" class="modal-detail-overlay">
        <div class="modal-detail-box">
            <h2 id="mdl-nama" class="mdl-title">Nama Produk</h2>

            <div class="mdl-top-content">
                <img id="mdl-foto" src="" alt="Foto Produk" class="mdl-img" onerror="this.src='/images/Logo ST.png'; this.style.objectFit='contain'; this.style.padding='10px';">

                <div class="mdl-info">
                    <div class="mdl-stok-wrap">
                        <span class="mdl-badge-kuning">Stok</span>
                        <span id="mdl-stok" class="mdl-stok-text">0 pcs</span>
                    </div>
                    <p id="mdl-deskripsi" class="mdl-desc">Deskripsi produk di sini...</p>
                    <h3 id="mdl-harga" class="mdl-price">Rp 0/Pcs</h3>
                </div>
            </div>

            <div class="mdl-bottom-content">
                <h4 class="mdl-subtitle">Keunggulan</h4>
                <ul id="mdl-keunggulan" class="mdl-list">
                </ul>
            </div>

            <div style="width: 100%; display: flex; justify-content: flex-end; margin-top: 35px;">
                <a href="#" id="mdl-btn-ubah" style="background-color: #FDE68A; color: #92400E; padding: 12px 40px; border-radius: 30px; font-weight: 700; text-decoration: none; transition: 0.3s; display: inline-block; font-size: 14px; border: none; outline: none; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.05);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Ubah Produk</a>
            </div>
        </div>
    </div>

    <script src="{{ url('js/produk-admin.js') }}"></script>
</body>
</html>
