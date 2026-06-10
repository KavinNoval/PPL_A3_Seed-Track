<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Data Mitra - Seed Track</title>
    {{-- CSS tetep panggil yang ini aja, style dropdown udah gabung di sini --}}
    <link rel="stylesheet" href="{{ asset('css/tambahstaf.css') }}">
</head>
<body>
    <div class="header">
        <h1>Membuat Data Mitra</h1>
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track">
    </div>

    <div class="content-form">
        @if(strtolower(trim(Auth::user()->role)) == 'admin')
            <a href="{{ route('data.mitra') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        @elseif(strtolower(trim(Auth::user()->role)) == 'staff lapang')
            <a href="{{ route('mitra.lapang') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        @endif

        <form action="{{ route('simpanmitra') }}" method="POST" class="form-card" id="formTambahMitra">
            @csrf

            <div id="pesanBatal" style="display: none; position: fixed; top: 90px; right: 30px; z-index: 9999; background-color: #ff0000; padding: 15px 25px; border-radius: 8px; color: white; font-weight: bold; box-shadow: 0 10px 15px rgba(0,0,0,0.2); border-left: 6px solid #8b0000;">
                Data mitra batal disimpan
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label class="wajib-isi">Nama Mitra</label>
                    <input type="text" name="nama_mitra" value="{{ old('nama_mitra') }}"
                           placeholder="Masukkan Mitra" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                           placeholder="Masukkan Nomor Telepon" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                    @error('no_telp')
                        <span style="color: red; font-size: 12px; margin-top: 5px; display: block;">*{{ $message }}</span>
                    @enderror
                </div>

                {{-- ================================================= --}}
                {{-- TAMBAHAN 3 DROPDOWN (KABUPATEN, KECAMATAN, DESA)  --}}
                {{-- ================================================= --}}

                <div class="form-group">
                    <label class="wajib-isi">Kabupaten</label>
                    <select name="id_kabupaten" id="id_kabupaten" required class="select-wilayah @error('id_kabupaten') is-invalid @enderror"
                            oninvalid="this.setCustomValidity('Pilih kabupaten terlebih dahulu')"
                            oninput="this.setCustomValidity('')">
                        <option value="" disabled selected>-- Pilih Kabupaten --</option>
                        {{-- Data ditarik dari Controller pas bikin Mitra Baru --}}
                        @if(isset($kabupatens))
                            @foreach($kabupatens as $kab)
                                <option value="{{ $kab->id_kabupaten }}" {{ old('id_kabupaten') == $kab->id_kabupaten ? 'selected' : '' }}>
                                    {{ $kab->kabupaten }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Kecamatan</label>
                    <select name="id_kecamatan" id="id_kecamatan" required class="select-wilayah @error('id_kecamatan') is-invalid @enderror"
                            oninvalid="this.setCustomValidity('Pilih kecamatan terlebih dahulu')"
                            oninput="this.setCustomValidity('')">
                        <option value="" disabled selected>-- Pilih Kecamatan --</option>
                        {{-- Diisi AJAX --}}
                    </select>
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Kelurahan / Desa</label>
                    <select name="id_kelurahan" id="id_kelurahan" required class="select-wilayah @error('id_kelurahan') is-invalid @enderror"
                            oninvalid="this.setCustomValidity('Pilih kelurahan terlebih dahulu')"
                            oninput="this.setCustomValidity('')">
                        <option value="" disabled selected>-- Pilih Kelurahan --</option>
                        {{-- Diisi AJAX --}}
                    </select>
                </div>

                {{-- ================================================= --}}

                <div class="form-group">
                    <label class="wajib-isi">Jalan Lahan</label>
                    <input type="text" name="jalan_lahan" value="{{ old('jalan_lahan') }}"
                           placeholder="Masukkan Jalan Lahan" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Blok Sawah</label>
                    <input type="text" name="blok_sawah" value="{{ old('blok_sawah') }}"
                           placeholder="Masukkan Blok Sawah" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Est. Benih</label>
                    <input type="number" name="est_benih" value="{{ old('est_benih') }}"
                           placeholder="Masukkan Est. Benih" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Est. Jumlah Panen</label>
                    <input type="number" name="est_jmlh_panen" value="{{ old('est_jmlh_panen') }}"
                           placeholder="Masukkan Jumlah Panen" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Luas Lahan</label>
                    <input type="number" step="0.01" name="luas_lahan" value="{{ old('luas_lahan') }}"
                           placeholder="Masukkan Luas Lahan" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Tanggal Bergabung</label>
                    <input type="date" name="tgl_bergabung" value="{{ old('tgl_bergabung') }}" required
                           oninvalid="this.setCustomValidity('Semua informasi harus diisi')"
                           oninput="this.setCustomValidity('')">
                </div>

                <button type="submit" class="btn-simpan" style="width: 100%;">SIMPAN</button>
            </div>
        </form>
    </div>

    <div id="modalKonfirmasiMitra" class="modal-overlay" style="display: none;">
        <div class="modal-box text-center" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); width: 350px; margin: auto; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
            <h4 style="margin-bottom: 25px; font-weight: normal;">Yakin ingin menyimpan<br>perubahan?</h4>
            <div class="modal-buttons" style="display: flex; justify-content: center; gap: 15px;">
                <button type="button" class="btn-modal btn-ya" id="btnYaMitra" style="background-color: #39ff14; color: black; border: none; padding: 10px 40px; border-radius: 50px; font-weight: 700; cursor: pointer;">Ya</button>
                <button type="button" class="btn-modal btn-batal" id="btnBatalEdit" style="background-color: #ff0000; color: black; border: none; padding: 10px 30px; border-radius: 50px; font-weight: 700; cursor: pointer;">Batal</button>
            </div>
        </div>
    </div>

    <script>
        window.oldKecamatan = "{{ old('id_kecamatan') }}";
        window.oldKelurahan = "{{ old('id_kelurahan') }}";
    </script>

    <script src="{{ asset('js/modal-mitra.js') }}?v={{ time() }}"></script>
</body>
</html>
