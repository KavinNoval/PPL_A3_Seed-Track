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
        <a href="{{ route('data.mitra') }}" class="btn-back">&larr;</a>
        
        <form action="{{ route('simpanmitra') }}" method="POST" class="form-card">
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
                    <label>Nama Mitra</label>
                    <input type="text" name="nama_mitra" placeholder="Masukkan Nama Mitra" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="no_telp" placeholder="Masukkan Nomor Telepon">
                </div>
                <div class="form-group">
                    <label>Jalan Lahan</label>
                    <input type="text" name="jalan_lahan" placeholder="Masukkan Jalan Lahan">
                </div>
                <div class="form-group">
                    <label>Blok Sawah</label>
                    <input type="text" name="blok_sawah" placeholder="Masukkan Blok Sawah">
                </div>
                <div class="form-group">
                    <label>Est. Benih</label>
                    <input type="number" name="est_benih" placeholder="Masukkan Est. Benih">
                </div>
                <div class="form-group">
                    <label>Est. Jumlah Panen</label>
                    <input type="number" name="est_jmlh_panen" placeholder="Masukkan Jumlah Panen">
                </div>
                <div class="form-group">
                    <label>Luas Lahan</label>
                    <input type="number" step="0.01" name="luas_lahan" placeholder="Masukkan Luas Lahan">
                </div>
                <div class="form-group">
                    <label>Tanggal Bergabung</label>
                    <input type="date" name="tgl_bergabung" placeholder="Masukkan Tanggal Bergabung">
                </div>
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>
</body>
</html>