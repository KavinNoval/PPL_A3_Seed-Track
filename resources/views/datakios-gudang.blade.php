<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kios - Staf Gudang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kiosgudang.css') }}">
</head>
<body>

    <div class="header-top">
        <div class="header-left">
            <a href="{{ route('dashboard.lapang') }}" class="btn-back">&larr;</a>
            
            <div class="search-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" placeholder="Cari">
            </div>
            
            <button class="btn-filter">
                Filter 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            </button>
        </div>
        <div class="header-right">
            Seed Track
            <img src="{{ asset('images/Logo ST.png') }}" alt="Seed Track Logo">
        </div>
    </div>

    <div class="kios-grid">
        @foreach($kios as $k)
        <div class="kios-card">
            <div class="kios-card-header">
                <div class="kios-card-header-left">
                    <img src="{{ asset('images/dashboardgudang/datakios.png') }}" alt="Kios" style="width: 24px; height: 24px; object-fit: contain;">
                    Kios
                </div>
                <a href="{{ route('editkios', $k->id_pelanggan) }}" style="color: #000;">
                    <img src="{{ asset('images/keperluandashboard/tabler_edit.png') }}" alt="Edit" style="width: 20px; height: 20px; object-fit: contain;">
                </a>
            </div>
            <div class="kios-card-body">
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

</body>
</html>