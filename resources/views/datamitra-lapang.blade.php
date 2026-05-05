<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mitra - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mitra-lapang.css') }}">
</head>
<body>

<main class="main-content">
    <header class="topbar-staf">
        <div style="display: flex; align-items: center; gap: 20px;">
            
            <a href="{{ url('/dashboard-lapang') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>

            <div class="top-action-bar">
                <input type="text" class="search-input" id="inputCariStaf" placeholder="Cari">
                <button class="btn-filter">Filter Y</button>
            </div>
        </div>

        <div class="topbar-logo">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
        </div>
    </header>

    @if(session('success'))
            <div class="pesan-otomatis" style="background-color: #48bb78; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #ffffff; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #2f855a;">
                {{ session('success') }}
            </div>
        @endif
        
        @if(request('status') == 'batal')
            <div class="pesan-otomatis" style="background-color: #ff0000ff; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #744210; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #b7791f;">
                Data mitra batal diubah
            </div>
        @endif

        @if(request('status') == 'batal_tambah')
            <div class="pesan-otomatis" style="background-color: #ff0000ff; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #744210; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #b7791f;">
                Data mitra batal disimpan
            </div>
        @endif

    <div class="staff-grid">
        @foreach($mitra as $m)
        <div class="staff-card">
            <div class="staff-header">
                <div class="staff-header-left">
                    <img src="{{ asset('images/keperluandashboard/gridadmin.png') }}" alt="Ikon Profil" style="width: 24px; height: 24px; object-fit: contain;">
                    Mitra
                </div>
                <div class="staff-header-right">
                    <a href="{{ route('editmitra', $m->id_mitra) }}">
                        <img src="{{ asset('images/keperluandashboard/tabler_edit.png') }}" alt="Edit" style="width: 20px; height: 20px; object-fit: contain;">
                    </a>
                </div>
            </div>
            <div class="staff-body">
                <div>Nama Mitra : {{ $m->nama_mitra ?? '-' }}</div>
                <div>Nomor Telepon : {{ $m->no_telp ?? '-' }}</div>
                <div>Jalan Lahan : {{ $m->jalan_lahan ?? '-' }}</div>
                <div>Blok Sawah : {{ $m->blok_sawah ?? '-' }}</div>
                <div>Luas Lahan : {{ $m->luas_lahan ?? '-' }}</div>
                <div>Est. Jumlah Panen : {{ $m->est_jmlh_panen ?? '-' }}</div>
                <div>Est. Benih : {{ $m->est_benih ?? '-' }}</div>
                <div>Tanggal Bergabung : {{ $m->tgl_bergabung ?? '-' }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <a href="{{ route('tambahinmitra') }}" class="fab-add">+</a>
</main>
<script src="{{ asset('js/notif.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>
</body>
</html>