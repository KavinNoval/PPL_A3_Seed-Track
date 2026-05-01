<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Data Mitra - Seed Track</title>
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Membuat Data Mitra</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>
    
    <div class="content-form">
        <a href="{{ route('data.mitra') }}" class="btn-back">&larr;</a>

        <form action="{{ route('simpanmitra') }}" method="POST" class="form-card" id="formTambahMitra">
            @csrf
            <div class="form-grid">
                
                <div class="form-group">
                    <label class="wajib-isi">Nama Mitra</label>
                    <input type="text" name="nama_mitra" value="{{ old('nama_mitra') }}" 
                    placeholder="Masukkan Mitra" required 
                    oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                    oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}" 
                           placeholder="Masukkan Nomor Telepon" required 
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Jalan Lahan</label>
                    <input type="text" name="jalan_lahan" value="{{ old('jalan_lahan') }}" 
                           placeholder="Masukkan Jalan Lahan" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Blok Sawah</label>
                    <input type="text" name="blok_sawah" value="{{ old('blok_sawah') }}" 
                           placeholder="Masukkan Blok Sawah" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Est. Benih</label>
                    <input type="number" name="est_benih" value="{{ old('est_benih') }}" 
                           placeholder="Masukkan Est. Benih" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Est. Jumlah Panen</label>
                    <input type="number" name="est_jmlh_panen" value="{{ old('est_jmlh_panen') }}" 
                           placeholder="Masukkan Jumlah Panen" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Luas Lahan</label>
                    <input type="number" step="0.01" name="luas_lahan" value="{{ old('luas_lahan') }}" 
                           placeholder="Masukkan Luas Lahan" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Tanggal Bergabung</label>
                    <input type="date" name="tgl_bergabung" value="{{ old('tgl_bergabung') }}" 
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>
                <button type="submit" class="btn-simpan" style="width: 100%;">SIMPAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasiMitra" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Apakah ingin menambah mitra?</p>
            <div class="modal-buttons">
                <button type="button" class="btn-modal btn-ya" id="btnYaMitra">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit" 
                        onclick="window.location.href='{{ route('batal.mitra', ['status' => 'batal_tambah']) }}'">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/modal-mitra.js') }}"></script>
</body>
</html>