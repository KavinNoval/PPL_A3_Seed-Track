<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Data Staf - Seed Track</title>
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Membuat Data Staf</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>

    <div class="content-form">
        <a href="{{ route('data.staf') }}" class="btn-back">&larr;</a>
        
        <form action="{{ route('rubahstaf') }}" method="POST" class="form-card" id="formTambahStaf">
            @csrf
            <div id="pesanBatal" style="display: none; position: fixed; top: 90px; right: 30px; z-index: 9999; background-color: #ff0000; padding: 15px 25px; border-radius: 8px; color: white; font-weight: bold; box-shadow: 0 10px 15px rgba(0,0,0,0.2); border-left: 6px solid #8b0000;">
                Data staf batal disimpan
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="wajib-isi">Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" required
                    oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                    oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="wajib-isi">Password</label>
                    <input type="text" name="password" placeholder="Masukkan Password" required
                    oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                    oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="wajib-isi">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required
                    oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                    oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="wajib-isi">Nomor Telepon</label>
                    <input type="text" name="no_telp" placeholder="Masukkan Nomor Telepon" required
                    oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                    oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="wajib-isi">Role</label>
                    <select name="role" required
                    oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                    oninput="this.setCustomValidity('')">
                        <option value="">Pilih Role</option>
                        <option value="Staff Lapang">Staf Lapang</option>
                        <option value="Staff Gudang">Staf Gudang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="wajib-isi">Status</label>
                    <select name="status" required
                    oninvalid="this.setCustomValidity('Semua informasi harus diisi')" 
                    oninput="this.setCustomValidity('')">
                        <option value="">Masukkan Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non Aktif">Non Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasi" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Apakah ingin menambah staf?</p>
            <div class="modal-buttons">
                <button type="button" class="btn-modal btn-ya" id="btnYa">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatal">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/modal-staf.js') }}"></script>
</body>
</html>