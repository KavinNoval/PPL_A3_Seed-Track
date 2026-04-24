<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mitra - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kiosgudang.css') }}">
</head>
<body>

<main class="main-content">
    <header class="topbar-staf">
        <div class="top-action-bar">
            <input type="text" class="search-input" placeholder="Cari">
            <button class="btn-filter">Filter Y</button>
        </div>
        <div class="topbar-logo">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
        </div>
    </header>

    <div class="staff-grid">
        @foreach($mitra as $m)
        <div class="staff-card">
            <div class="staff-header">
                <div class="staff-header-left">
                    <img src="{{ asset('images/keperluandashboard/gridadmin.png') }}" alt="Ikon Profil" style="width: 24px; height: 24px; object-fit: contain;">
                    Mitra
                </div>
                <div class="staff-header-right">
                    <a href="{{ route('editmitra', $m->id_pelanggan) }}">
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

</body>
</html>