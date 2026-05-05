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
            <div id="pesanBatal" style="display: none; position: fixed; top: 90px; right: 30px; z-index: 9999; background-color: #ff0000; padding: 15px 25px; border-radius: 8px; color: white; font-weight: bold; box-shadow: 0 10px 15px rgba(0,0,0,0.2); border-left: 6px solid #8b0000;">
                Data staf batal diubah
            </div>
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
                    @if(strtolower(trim($staf->role)) == 'admin')
                        <input type="text" name="role" value="{{ $staf->role }}" readonly 
                               style="background-color: #e9ecef; cursor: not-allowed; color: #6c757d; pointer-events: none;">
                    @else
                        <select name="role" required
                                oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                                oninput="this.setCustomValidity('')">
                            <option value="Admin" {{ strtolower(trim($staf->role)) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Staff Lapang" {{ strtolower(trim($staf->role)) == 'staff lapang' ? 'selected' : '' }}>Staf Lapang</option>
                            <option value="Staff Gudang" {{ strtolower(trim($staf->role)) == 'staff gudang' ? 'selected' : '' }}>Staf Gudang</option>
                        </select>
                    @endif
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Status</label>
                    @if(strtolower(trim($staf->role)) == 'admin')
                        <input type="text" name="status" value="{{ $staf->status ?? 'Aktif' }}" readonly 
                               style="background-color: #e9ecef; cursor: not-allowed; color: #6c757d; pointer-events: none;">
                    @else
                        <select name="status" required
                                oninvalid="this.setCustomValidity('Semua informasi harus lengkap')" 
                                oninput="this.setCustomValidity('')">
                            <option value="Aktif" {{ $staf->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Non Aktif" {{ $staf->status == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                        </select>
                    @endif
                </div>
                
                <button type="submit" class="btn-simpan" style="width: 100%;">SIMPAN PERUBAHAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasiEdit" class="modal-overlay" style="display: none;">
        <div class="modal-box" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); width: 350px; margin: auto; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; text-align: center;">
            <p style="font-weight: bold; margin-bottom: 25px;">Yakin ingin menyimpan<br>perubahan?</p>
            <div class="modal-buttons" style="display: flex; justify-content: center; gap: 20px;">
                <button type="button" class="btn-modal btn-ya" id="btnYaEdit" style="background-color: #39FF14; color: black; padding: 10px 30px; border-radius: 20px; border: none; font-weight: bold; cursor: pointer;">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit">Batal</button>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/modal-edit.js') }}"></script>
</body>
</html>