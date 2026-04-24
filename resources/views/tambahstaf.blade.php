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
        <form action="{{ route('rubahstaf') }}" method="POST" class="form-card">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" placeholder="Masukkan Password" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="no_telp" placeholder="Masukkan Nomor Telepon" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="Staff Lapang">Staf Lapang</option>
                        <option value="Staff Gudang">Staf Gudang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="">Masukkan Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non Aktif">Non Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>
</body>
</html>