<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kios - Seed Track</title>
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Edit Data Kios</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>
    
    <div class="content-form">
        <a href="{{ route('data.kios') }}" class="btn-back">&larr;</a>
        <form action="{{ route('updatekios', $kios->id_kios) }}" method="POST" class="form-card" id="formEditKios">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="wajib-isi">Nama Kios</label>
                    <input type="text" name="nama_kios" value="{{ old('nama_kios') ?? $kios->nama_kios }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" oninput="this.setCustomValidity('')">
                    @error('nama_kios') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') ?? $kios->nama_pemilik }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" oninput="this.setCustomValidity('')">
                    @error('nama_pemilik') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp') ?? $kios->no_telp }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" oninput="this.setCustomValidity('')">
                    @error('no_telp') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Alamat Kios</label>
                    <input type="text" name="alamat_kios" value="{{ old('alamat_kios') ?? $kios->alamat_kios }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" oninput="this.setCustomValidity('')">
                    @error('alamat_kios') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="wajib-isi">NIB</label>
                    <input type="text" name="NIB" value="{{ old('NIB') ?? $kios->NIB }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" oninput="this.setCustomValidity('')">
                    @error('NIB') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                
                <button type="submit" class="btn-simpan" style="width: 100%;">SIMPAN PERUBAHAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasiEdit" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Apakah ingin menyimpan perubahan?</p>
            <div class="modal-buttons">
                <button type="button" class="btn-modal btn-ya" id="btnYaEdit">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit" onclick="window.location.href='{{ route('batal.kios') }}'">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/modal-edit.js') }}"></script>
</body>
</html>