<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Staf - Seed Track</title>
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Edit Data Staf</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>
    
    <div class="content-form">
        <a href="{{ route('data.staf') }}" class="btn-back">&larr;</a>
        
        <form action="{{ route('updatestaf', $staf->id_akun) }}" method="POST" class="form-card" id="formEditStaf">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="wajib-isi">Username</label>
                    <input type="text" name="username" value="{{ $staf->username }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                           oninput="this.setCustomValidity('')">
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Password</label>
                    <input type="text" name="password" value="{{ $staf->password }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                           oninput="this.setCustomValidity('')">
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ $staf->nama_lengkap }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                           oninput="this.setCustomValidity('')">
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ $staf->no_telp }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                           oninput="this.setCustomValidity('')">
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Role</label>
                    <select name="role" required
                            oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                            oninput="this.setCustomValidity('')">
                        <option value="Staff Lapang" {{ $staf->role == 'Staff Lapang' ? 'selected' : '' }}>Staf Lapang</option>
                        <option value="Staff Gudang" {{ $staf->role == 'Staff Gudang' ? 'selected' : '' }}>Staf Gudang</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Status</label>
                    <select name="status" required
                            oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                            oninput="this.setCustomValidity('')">
                        <option value="Aktif" {{ $staf->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non Aktif" {{ $staf->status == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-simpan">SIMPAN PERUBAHAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasiEdit" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Yakin ingin menyimpan perubahan?</p>
            <div class="modal-buttons">
                <button type="button" class="btn-modal btn-ya" id="btnYaEdit">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit" onclick="window.location.href='{{ route('data.staf') }}?status=batal'">Batal</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal-edit.js') }}"></script>
</body>
</html>