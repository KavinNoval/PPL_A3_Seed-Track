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
        <div class="header-left" style="display: flex; align-items: center; gap: 15px;">
            <a href="{{ route('dashboard.gudang') }}" class="btn-back">&larr;</a>
            
            <input type="text" class="search-input" id="inputCariStaf" placeholder="Cari" 
                   style="padding: 10px 20px; border: 1px solid #ced4da; border-radius: 20px; outline: none; width: 250px; font-family: 'Inter', sans-serif;">
            
            <select id="filterDropdown" class="btn-filter" 
                    style="padding: 10px 20px; border: 1px solid #ced4da; border-radius: 20px; outline: none; cursor: pointer; background-color: white; font-family: 'Inter', sans-serif;">
                <option value="semua">Semua (Filter)</option>
                <option value="ada_nib">Ada NIB</option>
                <option value="tanpa_nib">Tanpa NIB</option>
            </select>
        </div>
        <div class="header-right">
            Seed Track
            <img src="{{ asset('images/Logo ST.png') }}" alt="Seed Track Logo">
        </div>
    </div>

    @if(session('success'))
        <div class="pesan-otomatis" style="background-color: #48bb78; padding: 12px 24px; border-radius: 8px; margin: 20px 0 20px auto; width: fit-content; color: #ffffff; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #2f855a;">
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