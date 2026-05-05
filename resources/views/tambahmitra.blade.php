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
        @if(strtolower(trim(Auth::user()->role)) == 'admin')
            <a href="{{ route('data.mitra') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        @elseif(strtolower(trim(Auth::user()->role)) == 'staff lapang')
            <a href="{{ route('mitra.lapang') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        @endif

        <form action="{{ route('simpanmitra') }}" method="POST" class="form-card" id="formTambahMitra">
            @csrf
            <div id="pesanBatal" style="display: none; position: fixed; top: 90px; right: 30px; z-index: 9999; background-color: #ff0000; padding: 15px 25px; border-radius: 8px; color: white; font-weight: bold; box-shadow: 0 10px 15px rgba(0,0,0,0.2); border-left: 6px solid #8b0000;">
                Data mitra batal disimpan
            </div>
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
                    <input type="date" name="tgl_bergabung" value="{{ old('tgl_bergabung') }}" required 
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
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/modal-mitra.js') }}"></script>
</body>
</html>