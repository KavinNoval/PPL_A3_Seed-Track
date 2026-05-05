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
        @if(strtolower(trim(Auth::user()->role)) == 'admin')
            <a href="{{ route('data.kios') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        @elseif(strtolower(trim(Auth::user()->role)) == 'staff gudang')
            <a href="{{ route('kios.gudang') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        @endif
        
        <form action="{{ route('simpankios') }}" method="POST" class="form-card" id="formTambahKios">
            @csrf
            <div id="pesanBatal" style="display: none; position: fixed; top: 90px; right: 30px; z-index: 9999; background-color: #ff0000; padding: 15px 25px; border-radius: 8px; color: white; font-weight: bold; box-shadow: 0 10px 15px rgba(0,0,0,0.2); border-left: 6px solid #8b0000;">
                Data kios batal disimpan
            </div>
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
                <button type="button" class="btn-modal btn-batal" id="btnBatalKios">Batal</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal-kios.js') }}"></script>
</body>
</html>