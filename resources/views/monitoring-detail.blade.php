<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Monitoring - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('css/monitoring.css') }}">
    <link rel="stylesheet" href="{{ url('css/monitoring-staf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tambah-produk.css') }}">
</head>
<body style="background-color: #f8fafc; margin: 0; padding: 0;">

    <div class="container-staf">

        <div class="header-staf" style="margin-bottom: 40px;">
            <div class="header-left-staf">
                <a href="{{ Auth::user()->role == 'Admin' ? route('monitoring.admin') : route('monitoring.staf') }}" class="back-btn-bulat">
                    <img src="{{ asset('images/Monitoring/panah.png') }}" alt="Back">
                </a>
            </div>

            <div class="logo-staf">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
            </div>
        </div>

        <div class="alert-fixed-container" id="alert-master-container">
            @if(session('success'))
                <div class="alert-3d alert-success">{{ session('success') }}</div>
            @endif

            @if(session('cancel') || session('error'))
                <div class="alert-3d alert-error">{{ session('cancel') ?? session('error') }}</div>
            @endif
        </div>

        <div class="page-title" style="display: flex; align-items: center; font-size: 22px; font-weight: 700; color: #2b3b1e; margin-bottom: 30px;">
            <img src="{{ asset('images/Monitoring/history.png') }}" alt="Riwayat" style="width: 28px; margin-right: 10px; object-fit: contain;">
            Riwayat Monitoring - <span style="margin-left: 6px; color: #84a96b;">{{ $mitra->nama_mitra }}</span>
        </div>

        {{-- 👇 INI YANG DIRUBAH BIAR TERSUSUN KE BAWAH 👇 --}}
        <div class="riwayat-grid" style="display: flex; flex-direction: column; gap: 25px;">
            @forelse($kumpulanSiklus as $index => $siklus)
                @php
                    // Cuma ambil data monitoring yang paling akhir di siklus ini
                    $r = $siklus->last();
                    $nomorSiklus = $index + 1;
                @endphp

                <a href="{{ route('editmonitoring', $r->id_monitoring) }}" class="riwayat-link" style="text-decoration: none; color: inherit; width: 350px;">
                    <div class="riwayat-card" style="background: #f1f5f9; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; position: relative;">

                        {{-- Label Siklus Tanam --}}
                        <div style="position: absolute; top: 12px; right: 12px; background: #eab308; color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; z-index: 10; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            Siklus #{{ $nomorSiklus }}
                        </div>

                        <div class="riwayat-header" style="padding: 15px 20px; border-bottom: 1px solid #cbd5e1; display: flex; align-items: center; gap: 10px; font-weight: 600; color: #0f172a;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            {{ \Carbon\Carbon::parse($r->tgl_survei)->translatedFormat('d F Y') }}
                        </div>

                        @if($r->foto_bukti)
                        <div class="riwayat-foto-wrapper">
                            <img src="{{ asset('foto_monitoring/' . $r->foto_bukti) }}" alt="Bukti Monitoring" style="width: 100%; height: 150px; object-fit: cover;">
                        </div>
                        @endif

                        <div class="riwayat-body" style="padding: 15px 20px;">
                            @php
                                $namaFaseTampil = $r->fase_tanam;
                                if($r->fase_tanam == 'Persemaian') { $namaFaseTampil = 'Fase Tanam'; }
                                if($r->fase_tanam == 'Vegetatif')  { $namaFaseTampil = 'Fase Vegetatif'; }
                                if($r->fase_tanam == 'Generatif')  { $namaFaseTampil = 'Fase Generatif'; }
                                if($r->fase_tanam == 'Panen')       { $namaFaseTampil = 'Fase Masak'; }
                            @endphp

                            <div class="fase-info" style="font-size: 14px; font-weight: 600; margin-bottom: 15px; color: #0f172a;">
                                Fase Saat Ini : <span style="color: #84a96b;">{{ $namaFaseTampil }}</span>
                            </div>

                            @if(strtolower($r->fase_tanam) == 'panen' || strtolower($r->fase_tanam) == 'masak')
                                <div class="status-badge" style="background: #2b3b1e; color: white; padding: 6px 20px; border-radius: 20px; display: inline-block; font-size: 14px; font-weight: 600;">Selesai</div>
                            @else
                                <div class="status-badge" style="background: #2b3b1e; color: white; padding: 6px 20px; border-radius: 20px; display: inline-block; font-size: 14px; font-weight: 600;">Proses</div>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <p class="empty-msg" style="width: 100%; text-align: center; color: #64748b; font-size: 16px;">
                    Mitra ini belum memiliki riwayat monitoring.
                </p>
            @endforelse
        </div>

        @php
            $bolehNambah = true;
            if (count($kumpulanSiklus) > 0) {
                $siklusTerakhir = $kumpulanSiklus[0];
                $faseTerakhir = $siklusTerakhir->last()->fase_tanam;

                // Kalo fase terbarunya BELUM panen/masak, HARAM nambah data siklus baru!
                if (strtolower($faseTerakhir) != 'panen' && strtolower($faseTerakhir) != 'masak') {
                    $bolehNambah = false;
                }
            }
        @endphp

        @if($bolehNambah)
            <a href="{{ route('tambahinmonitoring', $mitra->id_mitra) }}" style="position: fixed; bottom: 40px; right: 40px; width: 60px; height: 60px; background-color: #eab308; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); text-decoration: none; transition: 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">+</a>
        @else
            <div style="position: fixed; bottom: 40px; right: 40px; width: 60px; height: 60px; background-color: #cbd5e1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); cursor: not-allowed;" title="Selesaikan fase Panen/Masak terlebih dahulu sebelum menambah siklus tanam baru!">+</div>
        @endif

    </div>
    <script src="{{ asset('js/tambah-produk.js') }}"></script>
    <script src="{{ asset('js/modal-monitoring.js') }}"></script>
</body>
</html>
