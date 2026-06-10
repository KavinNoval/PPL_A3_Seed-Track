<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/editpengeluaran.css') }}?v={{ time() }}">
</head>
<body>

    <div class="header-top">
        <h1 class="header-title">Edit Data Pengeluaran</h1>
        <div class="logo-container">
            <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
            <img src="{{ asset('images/Logo ST.png') }}" alt="Logo">
        </div>
    </div>

    <div class="content-wrapper">
        <a href="{{ route('pengeluaran.index') }}" class="btn-back-circle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>

        @if(session('error'))
            <div style="background: #ff4d4f; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('pengeluaran.update', $pengeluaran->id_pengeluaran) }}" method="POST" enctype="multipart/form-data" id="formPengeluaran">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h2>Informasi Pengeluaran</h2>
                </div>

                <div class="form-grid">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Tanggal Pengeluaran <span>*</span></label>
                        <input type="date" name="tgl_pengeluaran" class="form-input" value="{{ \Carbon\Carbon::parse($pengeluaran->tgl_pengeluaran)->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Kategori <span>*</span></label>
                        <select name="id_akun" class="form-input" required>
                            <option value="2" {{ $pengeluaran->id_akun == 2 ? 'selected' : '' }}>Distribusi</option>
                            <option value="1" {{ $pengeluaran->id_akun == 1 ? 'selected' : '' }}>Operasional Kantor</option>
                            <option value="3" {{ $pengeluaran->id_akun == 3 ? 'selected' : '' }}>Pembelian Aset</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Pengeluaran <span>*</span></label>
                    <input type="text" name="nama_pengeluaran" class="form-input" value="{{ $pengeluaran->nama_pengeluaran }}" required>
                </div>

                <div class="form-group">
                    <label>Nominal (Rp) <span>*</span></label>
                    <input type="number" name="nominal" class="form-input" value="{{ $pengeluaran->nominal }}" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi Pengeluaran</label>
                    <textarea name="keterangan" class="form-input" rows="4">{{ $pengeluaran->keterangan }}</textarea>
                </div>

                <div class="form-group">
                    <label>Upload Bukti Nota Baru (Opsional)</label>
                    <input type="file" name="bukti_nota" accept="image/*,.pdf" class="form-input" style="background: white;">
                    <small style="color: #64748b; margin-top: 5px; display: block;">*Abaikan jika tidak ingin mengganti bukti nota lama.</small>

                    @if($pengeluaran->bukti_nota)
                        <div style="margin-top: 10px; padding: 10px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; display: inline-block;">
                            <span style="font-size: 12px; font-weight: bold; color: #1e293b; display: block; margin-bottom: 5px;">Bukti Saat Ini:</span>
                            <img src="{{ asset('foto_pengeluaran/' . $pengeluaran->bukti_nota) }}" style="max-height: 100px; border-radius: 6px; object-fit: contain;">
                        </div>
                    @endif
                </div>

                <div class="total-section">
                    <button type="button" class="btn-submit" onclick="bukaModalSimpan()">SIMPAN PERUBAHAN</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="modalKonfirmasiSimpan" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 99999; justify-content: center; align-items: center; backdrop-filter: blur(2px);">
        <div style="background: white; border-radius: 20px; padding: 40px 50px; box-shadow: 0 8px 30px rgba(0,0,0,0.2); text-align: center; max-width: 450px;">
            <p style="font-size: 18px; font-weight: 600; color: #111; margin: 0 0 30px 0; line-height: 1.5;">Yakin ingin menyimpan<br>perubahan?</p>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <button type="button" onclick="submitSimpan()" style="background-color: #39ff14; color: black; border: none; padding: 12px 40px; border-radius: 30px; cursor: pointer; font-weight: 700; font-size: 15px;">Ya</button>
                <button type="button" onclick="tutupKonfirmasiSimpan()" style="background-color: #ff0000; color: black; border: none; padding: 12px 40px; border-radius: 30px; cursor: pointer; font-weight: 700; font-size: 15px;">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/editpengeluaran.js') }}?v={{ time() }}"></script>
</body>
</html>
