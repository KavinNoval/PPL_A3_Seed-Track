<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lupapw.css') }}">
</head>
<body class="lupapw-page">

    <div class="logo-container">
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Seed Track Text" class="logo-text">
        <img src="{{ asset('images/Logo ST.png') }}" alt="Logo ST" class="logo-icon">
    </div>

    <div class="form-center-wrapper">
        <div class="form-center-container">
            <h1>Ubah Password</h1>

            @if (session('success'))
                <div style="background-color: #48bb78; color: white; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert-error" style="background: rgba(239, 68, 68, 0.9); color: white; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; text-align: left;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="wajib-isi">Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" value="{{ old('username') }}" required
                           oninvalid="this.setCustomValidity('Harap isi semua data')"
                           oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="wajib-isi">Password Lama</label>
                    <input type="password" name="current_password" placeholder="Masukkan Password Lama" required
                           oninvalid="this.setCustomValidity('Harap isi semua data')"
                           oninput="this.setCustomValidity('')">
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Password Baru</label>
                    <input type="password" name="password" placeholder="Masukkan Password Baru" required
                           oninvalid="this.setCustomValidity('Harap isi semua data')"
                           oninput="this.setCustomValidity('')">
                </div>
                
                <div class="form-group">
                    <label class="wajib-isi">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" required
                           oninvalid="this.setCustomValidity('Harap isi semua data')"
                           oninput="this.setCustomValidity('')">
                </div>
                
                <a href="{{ route('login') }}">Kembali ke Login?</a>
                
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        </div>
    </div>

</body>
</html>