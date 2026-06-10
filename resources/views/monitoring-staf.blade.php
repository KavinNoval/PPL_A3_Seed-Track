<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Lahan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/monitoring.css') }}">
</head>
<body style="display: flex; margin: 0; background-color: #f4f7f4; font-family: 'Inter', sans-serif;">

    <div class="main-content" style="flex: 1; padding: 40px 50px;">

        <div class="topbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">

    <div class="action-group" style="display: flex; gap: 15px; align-items: center;">

        <a href="{{ route('dashboard.lapang') }}" style="display: flex; justify-content: center; align-items: center; width: 45px; height: 45px; background-color: #2b3b1e; border-radius: 50%; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s;">
            <img src="{{ asset('images/Monitoring/panah.png') }}" alt="Kembali" style="width: 20px; filter: brightness(0) invert(1);">
        </a>

        <div class="search-pill" style="display: flex; align-items: center; border: 1px solid #cbd5e1; border-radius: 50px; padding: 10px 20px; width: 320px; background: white;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" class="search-input" placeholder="Cari nama mitra..." style="border: none; outline: none; margin-left: 10px; width: 100%; font-size: 0.95rem; background: transparent;">
        </div>
    </div>

    <div class="topbar-logo" style="display: flex; align-items: center;">
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track" style="height: 20px;">
        <img src="{{ asset('images/Logo ST.png') }}" alt="Logo" style="height: 35px; margin-left: 10px;">
    </div>
</div>
        <div class="monitoring-container">
            <div class="section-title" style="font-size: 1.5rem; font-weight: 800; color: #2D3A2E; margin-bottom: 25px;">Monitoring Aktivitas Lahan</div>

            <div class="card-table-monitoring" style="background: white; border-radius: 30px; padding: 40px 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                <table class="table-monitoring" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 10%; padding-bottom: 25px; border-bottom: 2px solid #f1f5f9; color: #475569; text-align: center;">NO</th>
                            <th style="width: 30%; padding-bottom: 25px; border-bottom: 2px solid #f1f5f9; color: #475569; text-align: left;">MITRA</th>
                            <th class="text-center" style="width: 30%; padding-bottom: 25px; border-bottom: 2px solid #f1f5f9; color: #475569; text-align: center;">FASE TERAKHIR</th>
                            <th class="text-center" style="width: 30%; padding-bottom: 25px; border-bottom: 2px solid #f1f5f9; color: #475569; text-align: center;">EST HASIL PANEN</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($dataMonitoring as $index => $item)
                            <tr class="data-row">
                                <td class="text-center" style="padding: 25px 0; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #1e293b;">{{ $index + 1 }}</td>
                                <td style="padding: 25px 0; border-bottom: 1px solid #f1f5f9; font-weight: 600;">
                                    <a href="{{ route('monitoring.detail', $item->id_mitra) }}" class="link-mitra" style="color: #1e293b; text-decoration: none;">
                                        {{ $item->nama_mitra }}
                                    </a>
                                </td>

                                @php
                                    $namaFaseTable = $item->fase_tanam;
                                    if($item->fase_tanam == 'Persemaian') { $namaFaseTable = 'Fase Tanam'; }
                                    if($item->fase_tanam == 'Vegetatif')  { $namaFaseTable = 'Fase Vegetatif'; }
                                    if($item->fase_tanam == 'Generatif')  { $namaFaseTable = 'Fase Generatif'; }
                                    if($item->fase_tanam == 'Panen' || $item->fase_tanam == 'Masak') { $namaFaseTable = 'Fase Masak'; }
                                @endphp
                                <td class="text-center" style="padding: 25px 0; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #1e293b;">
                                    {{ $namaFaseTable }}
                                </td>
                                <td class="text-center" style="padding: 25px 0; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #1e293b;">{{ $item->est_hasil_panen }} Kg</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="padding: 50px 0; color: #64748b; text-align: center; font-weight: 600;">
                                    Belum ada data monitoring lahan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="noDataMessage" style="display: none; text-align: center; color: #ef4444; padding: 30px; font-weight: 600;">
                    Data mitra tidak ditemukan
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/logout.js') }}"></script>
    <script src="{{ asset('js/search-monitor.js') }}"></script>
</body>
</html>
