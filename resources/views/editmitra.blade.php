<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mitra - Seed Track</title>
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Edit Data Mitra</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>
    
    <div class="content-form">
        <a href="{{ route('data.mitra') }}" class="btn-back">&larr;</a>
        <form action="{{ route('updatemitra', $mitra->id_mitra) }}" method="POST" class="form-card" id="formEditMitra">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="wajib-isi">Nama Mitra</label>
                    <input type="text" name="nama_mitra" 
                           value="{{ old('nama_mitra') ?? $mitra->nama_mitra }}" required
                           class="@error('nama_mitra') is-invalid @enderror">
                    @error('nama_mitra') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group">
                    <label class="wajib-isi">Nomor Telepon</label>
                    <input type="text" name="no_telp" 
                           value="{{ old('no_telp') ?? $mitra->no_telp }}" required
                           class="@error('no_telp') is-invalid @enderror">
                    @error('no_telp') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Jalan Lahan -->
                <div class="form-group">
                    <label class="wajib-isi">Jalan Lahan</label>
                    <input type="text" name="jalan_lahan" 
                           value="{{ old('jalan_lahan') ?? $mitra->jalan_lahan }}" required
                           class="@error('jalan_lahan') is-invalid @enderror">
                    @error('jalan_lahan') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Blok Sawah -->
                <div class="form-group">
                    <label class="wajib-isi">Blok Sawah</label>
                    <input type="text" name="blok_sawah" 
                           value="{{ old('blok_sawah') ?? $mitra->blok_sawah }}" required
                           class="@error('blok_sawah') is-invalid @enderror">
                    @error('blok_sawah') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Est. Benih -->
                <div class="form-group">
                    <label class="wajib-isi">Est. Benih</label>
                    <input type="number" name="est_benih" 
                           value="{{ old('est_benih') ?? $mitra->est_benih }}" required
                           class="@error('est_benih') is-invalid @enderror">
                    @error('est_benih') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Est. Jumlah Panen -->
                <div class="form-group">
                    <label class="wajib-isi">Est. Jumlah Panen</label>
                    <input type="number" name="est_jmlh_panen" 
                           value="{{ old('est_jmlh_panen') ?? $mitra->est_jmlh_panen }}" required
                           class="@error('est_jmlh_panen') is-invalid @enderror">
                    @error('est_jmlh_panen') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <!-- Luas Lahan -->
                <div class="form-group">
                    <label class="wajib-isi">Luas Lahan</label>
                    <input type="number" step="0.01" name="luas_lahan" 
                           value="{{ old('luas_lahan') ?? $mitra->luas_lahan }}" required
                           class="@error('luas_lahan') is-invalid @enderror">
                    @error('luas_lahan') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="wajib-isi">Tanggal Bergabung</label>
                    <input type="date" name="tgl_bergabung" 
                           value="{{ old('tgl_bergabung') ?? $mitra->tgl_bergabung }}" required
                           class="@error('tgl_bergabung') is-invalid @enderror">
                    @error('tgl_bergabung') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <button type="button" class="btn-simpan" id="btnTampilkanModal" style="width: 100%;">SIMPAN PERUBAHAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasiEdit" class="modal-overlay" style="display: none;">
        <div class="modal-box text-center" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); width: 350px; margin: auto; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
            <h4 style="margin-bottom: 25px; font-weight: normal;">Yakin ingin menyimpan<br>perubahan?</h4>
            <div class="modal-buttons">
                <button type="button" class="btn-modal btn-ya" id="btnYaEdit">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit" onclick="window.location.href='{{ route('batal.mitra') }}'">Batal</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal-edit.js') }}"></script>
</body>
</html>