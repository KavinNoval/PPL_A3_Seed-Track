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
        
        <form action="{{ route('simpankios') }}" method="POST" class="form-card">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Kelurahan</label>
                    <select name="id_kelurahan" required>
                        <option value="">Pilih Kelurahan</option>
                        <option value="1">Sumbersari</option>
                        <option value="2">Patrang</option>
                        <option value="3">Kaliwates</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Kios</label>
                    <input type="text" name="nama_kios" placeholder="Masukkan Nama Kios" required>
                </div>
                <div class="form-group">
                    <label>Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" placeholder="Masukkan Nama Pemilik" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="no_telp" placeholder="Masukkan Nomor Telepon">
                </div>
                <div class="form-group">
                    <label>Alamat Kios</label>
                    <input type="text" name="alamat_kios" placeholder="Masukkan Alamat Kios">
                </div>
                <div class="form-group">
                    <label>NIB</label>
                    <input type="text" name="NIB" placeholder="Masukkan NIB">
                </div>
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>
</body>
</html>