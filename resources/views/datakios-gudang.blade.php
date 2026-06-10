<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kios - Staf Gudang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kiosgudang.css') }}">
</head>
<body style="background-color: #f4f7f4; font-family: 'Inter', sans-serif; margin: 0; padding: 20px 40px;">

    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div style="display: flex; align-items: flex-start; gap: 20px;">
            <a href="{{ route('dashboard.gudang') }}" class="btn-back-circle" style="margin-top: 3px; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background-color: #2D3A2E; border-radius: 50%; text-decoration: none; transition: 0.3s;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>

            <div class="page-header">
                <h1 class="page-title" style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 5px; margin-top: 0;">Data Kios</h1>
                <p class="page-description" style="font-size: 0.95rem; color: #64748b; margin-top: 0;">Kelola dan pantau data kios penyalur yang bekerjasama dengan perusahaan.</p>
            </div>
        </div>

        <div class="topbar-logo" style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track" style="height: 35px;">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" style="height: 35px;">
        </div>
    </div>

    <div class="topbar-action" style="margin-bottom: 25px;">
        <div style="display: flex; gap: 15px; align-items: center;">

            <div class="search-pill" style="display: flex; align-items: center; width: 300px; background: white; padding: 10px 20px; border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #ced4da;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" class="search-input" id="inputCariStaf" placeholder="Cari Kios..." style="border: none; outline: none; background: transparent; width: 100%; margin-left: 10px; font-size: 0.95rem; font-family: 'Inter', sans-serif;">
            </div>

            <select id="filterDropdown" class="btn-filter" style="padding: 10px 20px; border: 1px solid #ced4da; border-radius: 20px; outline: none; cursor: pointer; background-color: white; font-family: 'Inter', sans-serif;">
                <option value="semua">Semua (Filter)</option>
                <option value="ada_nib">Ada NIB</option>
                <option value="tanpa_nib">Tanpa NIB</option>
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="pesan-otomatis" style="background-color: #48bb78; padding: 12px 24px; border-radius: 8px; margin: 0 0 20px auto; width: fit-content; color: #ffffff; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #2f855a;">
            {{ session('success') }}
        </div>
    @endif

    <div class="kios-grid">
        @foreach($kios as $k)
        <div class="kios-card">
            <div class="kios-card-header">
                <div class="kios-card-header-left">
                    <img src="{{ asset('images/dashboardgudang/datakios.png') }}" alt="Kios" style="width: 24px; height: 24px; object-fit: contain;">
                    Kios
                </div>
                <a href="{{ route('editkios', $k->id_kios) }}" style="color: #000;">
                    <img src="{{ asset('images/keperluandashboard/tabler_edit.png') }}" alt="Edit" style="width: 20px; height: 20px; object-fit: contain;">
                </a>
            </div>
            <div class="kios-card-body">
                <div>Nama Kios : {{ $k->nama_kios ?? '-' }}</div>
                <div>Nama Pemilik : {{ $k->nama_pemilik ?? '-' }}</div>
                <div>Nomor Telepon : {{ $k->no_telp ?? '-' }}</div>
                <div>Kabupaten : {{ $k->kabupaten ?? '-' }}</div>
                <div>Kecamatan : {{ $k->kecamatan ?? '-' }}</div>
                <div>Kelurahan / Desa : {{ $k->kelurahan ?? '-' }}</div>
                <div>Alamat Kios : {{ $k->alamat_kios ?? '-' }}</div>
                <div>NIB : {{ $k->NIB ?? '-' }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <a href="{{ route('tambahinkios') }}" class="fab-add">+</a>
    <script src="{{ asset('js/notif.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>
