<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Monitoring - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/monitoring.css') }}?v={{ time() }}">
</head>
<body class="body-form-monitoring tanpa-sidebar" style="margin: 0; background-color: #f8fafc;">

    {{-- LOGIKA DETEKSI DATA BARU BUAT NGE-UNLOCK FORM FASE MASAK --}}
    @php
        $isBaru = empty($monitoring->id_monitoring);
    @endphp

    <div class="container-form">
        <div class="header-form-bar" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 50px; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000;">

            <a href="{{ route('monitoring.detail', $mitra->id_mitra) }}" class="back-btn-form" style="background: #2D3A2E; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>

            <div class="fase-tabs" style="display: flex; gap: 10px; flex: 1; justify-content: center;">

                @if($semuaFase->firstWhere('fase_tanam', 'Persemaian'))
                    <a href="{{ route('editmonitoring', $semuaFase->firstWhere('fase_tanam', 'Persemaian')->id_monitoring) }}"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Persemaian' ? 'active' : '' }}"
                       style="text-decoration: none;">Fase Tanam</a>
                @else
                    <a href="{{ route('tambahinmonitoring', $mitra->id_mitra) }}?fase=Persemaian"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Persemaian' ? 'active' : '' }}"
                       style="text-decoration: none; {{ $monitoring->fase_tanam != 'Persemaian' ? 'color: #94a3b8; background: #f8fafc;' : '' }} cursor: pointer !important;">Fase Tanam</a>
                @endif

                @if($semuaFase->firstWhere('fase_tanam', 'Vegetatif'))
                    <a href="{{ route('editmonitoring', $semuaFase->firstWhere('fase_tanam', 'Vegetatif')->id_monitoring) }}"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Vegetatif' ? 'active' : '' }}"
                       style="text-decoration: none;">Fase Vegetatif</a>
                @else
                    <a href="{{ route('tambahinmonitoring', $mitra->id_mitra) }}?fase=Vegetatif"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Vegetatif' ? 'active' : '' }}"
                       style="text-decoration: none; {{ $monitoring->fase_tanam != 'Vegetatif' ? 'color: #94a3b8; background: #f8fafc;' : '' }} cursor: pointer !important;">Fase Vegetatif</a>
                @endif

                @if($semuaFase->firstWhere('fase_tanam', 'Generatif'))
                    <a href="{{ route('editmonitoring', $semuaFase->firstWhere('fase_tanam', 'Generatif')->id_monitoring) }}"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Generatif' ? 'active' : '' }}"
                       style="text-decoration: none;">Fase Generatif</a>
                @else
                    <a href="{{ route('tambahinmonitoring', $mitra->id_mitra) }}?fase=Generatif"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Generatif' ? 'active' : '' }}"
                       style="text-decoration: none; {{ $monitoring->fase_tanam != 'Generatif' ? 'color: #94a3b8; background: #f8fafc;' : '' }} cursor: pointer !important;">Fase Generatif</a>
                @endif

                @if($semuaFase->firstWhere('fase_tanam', 'Panen'))
                    <a href="{{ route('editmonitoring', $semuaFase->firstWhere('fase_tanam', 'Panen')->id_monitoring) }}"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Panen' ? 'active' : '' }}"
                       style="text-decoration: none;">Fase Masak</a>
                @else
                    <a href="{{ route('tambahinmonitoring', $mitra->id_mitra) }}?fase=Panen"
                       class="fase-tab {{ $monitoring->fase_tanam == 'Panen' ? 'active' : '' }}"
                       style="text-decoration: none; {{ $monitoring->fase_tanam != 'Panen' ? 'color: #94a3b8; background: #f8fafc;' : '' }} cursor: pointer !important;">Fase Masak</a>
                @endif
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text" style="height: 20px;">
                <img src="{{ asset('images/Logo ST.png') }}" alt="Logo ST" style="height: 35px;">
            </div>
        </div>

        <div class="alert-fixed-container" id="alert-master-container">
            @if(session('success'))
                <div class="alert-3d alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-3d alert-error">{{ session('error') }}</div>
            @endif
        </div>

        <div class="laporan-title" style="margin-top: 30px;">
            {{ $isBaru ? 'Tambah Laporan Monitoring' : 'Laporan Monitoring' }}
        </div>

        <form id="formEditMonitoring" action="{{ $monitoring->id_monitoring ? route('updatemonitoring') : route('simpanmonitoring') }}" method="POST" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
            @csrf

            <input type="hidden" name="id_mitra" value="{{ $mitra->id_mitra }}">
            <input type="hidden" name="id_monitoring" value="{{ $monitoring->id_monitoring }}">
            <input type="hidden" name="fase_tanam" id="input_fase_tanam" value="{{ $monitoring->fase_tanam }}">

            <div class="form-grid">
                <div>
                    <div class="form-group">
                        <label>Tgl Survei <span style="color: red;">*</span></label>
                        <input type="date" name="tgl_survei" class="input-gray wajib-isi {{ $isBaru ? '' : 'input-lock mode-view' }}" value="{{ $monitoring->tgl_survei }}" {{ $isBaru ? '' : 'disabled' }} required>
                    </div>

                    <div class="form-group">
                        <label>Kondisi Tanaman <span style="color: red;">*</span></label>
                        <select name="kondisi_tanaman" class="input-gray wajib-isi {{ $isBaru ? '' : 'input-lock mode-view' }}" {{ $isBaru ? '' : 'disabled' }} required>
                            <option value="Sehat" {{ $monitoring->kondisi_tanaman == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                            <option value="Terserang Hama" {{ $monitoring->kondisi_tanaman == 'Terserang Hama' ? 'selected' : '' }}>Terserang Hama</option>
                            <option value="Kekurangan Air" {{ $monitoring->kondisi_tanaman == 'Kekurangan Air' ? 'selected' : '' }}>Kekurangan Air</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kondisi Lapangan <span style="color: red;">*</span></label>
                        <textarea name="kondisi_lapangan" class="input-gray wajib-isi {{ $isBaru ? '' : 'input-lock mode-view' }}" rows="5" {{ $isBaru ? '' : 'disabled' }} required>{{ $monitoring->kondisi_lapangan }}</textarea>
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label>Perkiraan Panen <span style="color: red;">*</span></label>
                        <input type="date" name="perkiraan_panen" class="input-gray wajib-isi {{ $isBaru ? '' : 'input-lock mode-view' }}" value="{{ $monitoring->perkiraan_panen }}" {{ $isBaru ? '' : 'disabled' }} required>
                    </div>
                    <div class="form-group">
                        <label>Est Hasil Panen <span style="color: red;">*</span></label>
                        <input type="text" name="est_hasil_panen" class="input-gray wajib-isi {{ $isBaru ? '' : 'input-lock mode-view' }}" value="{{ $monitoring->est_hasil_panen }}" {{ $isBaru ? '' : 'disabled' }} required>
                    </div>

                    <div class="form-group">
                        <label>Foto Bukti</label>

                        <div class="upload-box-new" id="box-foto"
                             style="position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px dashed #cbd5e1; border-radius: 8px; min-height: 180px; padding: 10px; background: white; overflow: hidden; width: 100%; box-sizing: border-box;">

                            <div id="buntelan_awal" style="display: {{ $monitoring->foto_bukti ? 'none' : 'flex' }}; flex-direction: column; align-items: center; gap: 8px;">
                                <img src="{{ asset('images/Monitoring/bukti.png') }}" alt="Default" style="width: 32px; opacity: 0.5;">
                                <span style="font-size: 14px; color: #64748b; text-align: center;">Belum ada foto</span>
                            </div>

                            <img id="preview_foto_mantap"
                                 src="{{ $monitoring->foto_bukti ? asset('foto_monitoring/' . $monitoring->foto_bukti) : '' }}"
                                 alt="Preview"
                                 style="display: {{ $monitoring->foto_bukti ? 'block' : 'none' }}; width: 100%; max-height: 220px; object-fit: contain; border-radius: 6px;">
                        </div>

                        <div class="upload-options {{ $isBaru ? '' : 'mode-view-hide' }}" style="display: {{ $isBaru ? 'flex' : 'none' }}; width: 100%;">
                            <button type="button" class="btn-upload-option" id="btnPilihGaleri">Pilih dari Galeri</button>
                            <button type="button" class="btn-upload-option" id="btnAmbilFoto">Ambil Foto</button>
                        </div>

                        <input type="file" id="foto_upload_utama" name="foto_bukti" accept="image/*" style="display: none;" onchange="sihirPreviewEdit(event)">
                    </div>
                </div>
            </div>

            <div class="btn-submit-wrap">
                <button type="button" id="btn-buka-edit" class="btn-submit" style="display: {{ $isBaru ? 'none' : 'block' }};">UBAH</button>
                <button type="button" id="btn-simpan-perubahan" class="btn-submit" style="display: {{ $isBaru ? 'block' : 'none' }}; background-color: #4dfd00; color: black;">
                    {{ $isBaru ? 'SIMPAN' : 'SIMPAN PERUBAHAN' }}
                </button>
            </div>
        </form>
    </div>

    <div id="modalEdit" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p class="modal-text">Yakin ingin menyimpan<br>perubahan?</p>
            <div class="modal-buttons">
                <button type="button" id="confirmEdit" class="btn-modal btn-ya">Ya</button>
                <button type="button" id="cancelEdit" class="btn-modal btn-batal close-modal">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/modal-monitoring.js') }}?v={{ time() }}"></script>

</body>
</html>
