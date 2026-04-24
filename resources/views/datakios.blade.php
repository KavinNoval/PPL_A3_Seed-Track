<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kios - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
            @foreach($kios as $k)
            <div class="staff-card">
                <div class="staff-header">
                    <div class="staff-header-left">
                        <img src="{{ asset('images/keperluandashboard/gridadmin.png') }}" alt="Ikon Kios" style="width: 24px; height: 24px; object-fit: contain;">
                        Kios
                    </div>
                    <div class="staff-header-right">
                        <a href="{{ route('editkios', $k->id_pelanggan) }}">
                            <img src="{{ asset('images/keperluandashboard/tabler_edit.png') }}" alt="Edit" style="width: 20px; height: 20px; object-fit: contain;">
                        </a>
                    </div>
                </div>
                <div class="staff-body">
                    <div>Nama Kios : {{ $k->nama_kios ?? '-' }}</div>
                    <div>Nama Pemilik : {{ $k->nama_pemilik ?? '-' }}</div>
                    <div>Nomor Telepon : {{ $k->no_telp ?? '-' }}</div>
                    <div>Alamat Kios : {{ $k->alamat_kios ?? '-' }}</div>
                    <div>NIB : {{ $k->NIB ?? '-' }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('tambahinkios') }}" class="fab-add">+</a>

    </main>

</body>
</html>