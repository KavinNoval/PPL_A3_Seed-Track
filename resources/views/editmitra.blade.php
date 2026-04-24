<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mitra - Seed Track</title>
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Edit Data Mitra</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>
    
    <div class="content-form">
        <a href="{{ route('data.mitra') }}" class="btn-back">&larr;</a>
        
        <form action="{{ route('updatemitra', $mitra->id_pelanggan) }}" method="POST" class="form-card">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Kelurahan</label>
                    <select name="id_kelurahan" required>
                        <option value="">Pilih Kelurahan</option>
                        <option value="1" {{ $mitra->id_kelurahan == 1 ? 'selected' : '' }}>Sumbersari</option>
                        <option value="2" {{ $mitra->id_kelurahan == 2 ? 'selected' : '' }}>Patrang</option>
                        <option value="3" {{ $mitra->id_kelurahan == 3 ? 'selected' : '' }}>Kaliwates</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Mitra</label>
                    <input type="text" name="nama_mitra" value="{{ $mitra->nama_mitra }}" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ $mitra->no_telp }}">
                </div>
                <div class="form-group">
                    <label>Jalan Lahan</label>
                    <input type="text" name="jalan_lahan" value="{{ $mitra->jalan_lahan }}">
                </div>
                <div class="form-group">
                    <label>Blok Sawah</label>
                    <input type="text" name="blok_sawah" value="{{ $mitra->blok_sawah }}">
                </div>
                <div class="form-group">
                    <label>Est. Benih</label>
                    <input type="number" name="est_benih" value="{{ $mitra->est_benih }}">
                </div>
                <div class="form-group">
                    <label>Est. Jumlah Panen</label>
                    <input type="number" name="est_jmlh_panen" value="{{ $mitra->est_jmlh_panen }}">
                </div>
                <div class="form-group">
                    <label>Luas Lahan</label>
                    <input type="number" step="0.01" name="luas_lahan" value="{{ $mitra->luas_lahan }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Bergabung</label>
                    <input type="date" name="tgl_bergabung" value="{{ $mitra->tgl_bergabung }}">
                </div>
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>
</body>
</html>