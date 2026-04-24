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
        
        <form action="{{ route('updatekios', $kios->id_pelanggan) }}" method="POST" class="form-card">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Kelurahan</label>
                    <select name="id_kelurahan" required>
                        <option value="">Pilih Kelurahan</option>
                        <option value="1" {{ $kios->id_kelurahan == 1 ? 'selected' : '' }}>Sumbersari</option>
                        <option value="2" {{ $kios->id_kelurahan == 2 ? 'selected' : '' }}>Patrang</option>
                        <option value="3" {{ $kios->id_kelurahan == 3 ? 'selected' : '' }}>Kaliwates</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Kios</label>
                    <input type="text" name="nama_kios" value="{{ $kios->nama_kios }}" required>
                </div>
                <div class="form-group">
                    <label>Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" value="{{ $kios->nama_pemilik }}" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ $kios->no_telp }}">
                </div>
                <div class="form-group">
                    <label>Alamat Kios</label>
                    <input type="text" name="alamat_kios" value="{{ $kios->alamat_kios }}">
                </div>
                <div class="form-group">
                    <label>NIB</label>
                    <input type="text" name="NIB" value="{{ $kios->NIB }}">
                </div>
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>
</body>
</html>