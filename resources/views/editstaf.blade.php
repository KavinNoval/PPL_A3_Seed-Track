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
        
        <form action="{{ route('update', $staf->id_akun) }}" method="POST" class="form-card">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ $staf->username }}" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" value="{{ $staf->password }}" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ $staf->nama_lengkap }}" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ $staf->no_telp }}" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="Staff Lapang" {{ $staf->role == 'Staff Lapang' ? 'selected' : '' }}>Staf Lapang</option>
                        <option value="Staff Gudang" {{ $staf->role == 'Staff Gudang' ? 'selected' : '' }}>Staf Gudang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Aktif" {{ $staf->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non Aktif" {{ $staf->status == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>
</body>
</html>