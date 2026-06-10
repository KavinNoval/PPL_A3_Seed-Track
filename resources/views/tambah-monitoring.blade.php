<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Data Monitoring - Seed Track</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/tambah-monitoring.css') }}">

    <style>
        .upload-options {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-upload-option {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            background: #16a34a;
            color: white;
            transition: 0.2s;
        }

        .btn-upload-option:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="header-white">
    <h2>Membuat Data Monitoring</h2>

    <div class="alert-fixed-container" id="alert-master-container"></div>

    <div style="display: flex; align-items: center; gap: 10px;">
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text" style="height: 20px;">
        <img src="{{ asset('images/Logo ST.png') }}" alt="Logo ST" style="height: 35px;">
    </div>
</div>

<div class="content-area">

    <a href="{{ route('monitoring.detail', $mitra->id_mitra) }}" class="back-btn-circle">
        <img src="{{ asset('images/Monitoring/panah.png') }}" alt="Kembali">
    </a>

    <div class="form-card clearfix">

        <form id="formTambahMonitoring"
              action="{{ route('simpanmonitoring') }}"
              method="POST"
              enctype="multipart/form-data"
              onkeydown="return event.key != 'Enter';">

            @csrf

            <input type="hidden" name="id_mitra" value="{{ $mitra->id_mitra }}">
            <input type="hidden" name="fase_tanam" value="{{ request()->query('fase') ?? 'Persemaian' }}">

            <div class="form-grid">

                <div>

                    <div class="form-group">
                        <label>Tgl Survei <span class="asterisk">*</span></label>

                        <input type="date"
                               name="tgl_survei"
                               class="input-box"
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Kondisi Tanaman <span class="asterisk">*</span></label>

                        <select name="kondisi_tanaman"
                                class="input-box"
                                required>

                            <option value="Sehat">Bagus / Sehat</option>
                            <option value="Terserang Hama">Terserang Hama</option>
                            <option value="Kekurangan Air">Kekurangan Air</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kondisi Lapangan <span class="asterisk">*</span></label>

                        <textarea name="kondisi_lapangan"
                                  class="input-box"
                                  placeholder="Kondisi lahan..."
                                  rows="4"
                                  required></textarea>
                    </div>

                </div>

                <div>

                    <div class="form-group">
                        <label>Perkiraan Panen <span class="asterisk">*</span></label>

                        <input type="date"
                               name="perkiraan_panen"
                               class="input-box"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Est Hasil Panen <span class="asterisk">*</span></label>

                        <input type="number"
                               name="est_hasil_panen"
                               class="input-box"
                               placeholder="Contoh: 500"
                               required>
                    </div>

                    <div class="form-group">

                        <label>Upload Foto Bukti <span class="asterisk">*</span></label>

                        <div class="upload-box-new"
                             id="box-foto"
                             style="
                                position: relative;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                border: 2px dashed #cbd5e1;
                                border-radius: 8px;
                                min-height: 180px;
                                padding: 10px;
                                background: white;
                                overflow: hidden;
                                width: 100%;
                                box-sizing: border-box;
                             ">

                            <div id="buntelan_awal"
                                 style="
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    gap: 8px;
                                 ">

                                <img src="{{ asset('images/Monitoring/bukti.png') }}"
                                     alt="Default"
                                     style="width: 32px; opacity: 0.5;">

                                <span style="
                                    font-size: 14px;
                                    color: #64748b;
                                    text-align: center;
                                ">
                                    Belum ada foto
                                </span>
                            </div>

                            <img id="preview_foto_mantap"
                                 src=""
                                 alt="Preview"
                                 style="
                                    display: none;
                                    width: 100%;
                                    max-height: 220px;
                                    object-fit: contain;
                                    border-radius: 6px;
                                 ">

                        </div>

                        <div class="upload-options">
                            <button type="button"
                                    class="btn-upload-option"
                                    onclick="bukaGaleri()">
                                Pilih dari Galeri
                            </button>

                            <button type="button"
                                    class="btn-upload-option"
                                    onclick="bukaKamera()">
                                Ambil Foto
                            </button>
                        </div>

                        <input type="file"
                               id="foto_upload_utama"
                               name="foto_bukti"
                               accept="image/*"
                               style="display: none;"
                               onchange="window.sihirPreviewEdit(event)"
                               required>

                    </div>

                </div>

            </div>

            <button type="button"
                    id="btn-submit-trigger"
                    class="btn-simpan">
                SIMPAN
            </button>

        </form>

    </div>
</div>

<div id="modalAdd"
     class="modal-overlay"
     style="display: none;">

    <div class="modal-box">

        <p class="modal-text">
            Apakah ingin menambah<br>Monitoring?
        </p>

        <div class="modal-buttons">

            <button type="button"
                    id="confirmAdd"
                    class="btn-modal btn-ya">
                Ya
            </button>

            <button type="button"
                    class="btn-modal btn-batal close-modal">
                Batal
            </button>

        </div>

    </div>
</div>

<script src="{{ asset('js/modal-monitoring.js') }}?v={{ time() }}"></script>

</body>
</html>
