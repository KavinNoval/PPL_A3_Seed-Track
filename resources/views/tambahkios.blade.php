<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Data Kios - Seed Track</title>
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Membuat Data Kios</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>
    
    <div class="content-form">
        <a href="{{ route('data.kios') }}" class="btn-back">&larr;</a>
        
        <form action="{{ route('simpankios') }}" method="POST" class="form-card" id="formTambahKios">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="wajib-isi">Nama Kios</label>
                    <input type="text" name="nama_kios" value="{{ old('nama_kios') }}" 
                           placeholder="Masukkan Kios" required 
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}" 
                           placeholder="Masukkan Nama pemilik" required 
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
                    <label class="wajib-isi">Alamat Kios</label>
                    <input type="text" name="alamat_kios" value="{{ old('alamat_kios') }}" 
                           placeholder="Masukkan Alamat" required 
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>

                <!-- NIB -->
                <div class="form-group">
                    <label class="wajib-isi">NIB</label>
                    <input type="text" name="NIB" value="{{ old('NIB') }}" 
                           placeholder="Masukkan NIB" required 
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                           oninput="this.setCustomValidity('')">
                </div>
                <button type="submit" class="btn-simpan" style="width: 100%;">SIMPAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasiKios" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Apakah ingin menambah kios?</p>
            <div class="modal-buttons">
                <button type="button" id="btnYaKios" class="btn-modal btn-ya">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit" onclick="window.location.href='{{ route('batal.kios', ['status' => 'batal_tambah']) }}'">Batal</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal-kios.js') }}"></script>
</body>
</html>