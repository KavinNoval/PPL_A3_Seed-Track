<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman login Seed Track - Sistem manajemen pertanian">
    <title>Login - Seed Track</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-container">
        <img src="{{ asset('images/background.png') }}" alt="Sawah Background" class="bg-image">
        <div class="logo-container">
        <img src="{{ asset('images/Seed Track - Text.png') }}" alt="Logo Text" class="logo-text">
        <img src="{{ asset('images/Logo ST.png') }}" alt="Logo Icon" class="logo-icon">
        </div>
        <div class="glass-panel">
            <div class="form-heading">
                <h1>Halo Para Staf<br>Tercinta</h1>
            </div>

            @if(session('success'))
                <div style="background-color: #48bb78; padding: 12px 24px; border-radius: 8px; margin: 0 auto 20px auto; width: fit-content; color: #ffffff; font-weight: bold; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #2f855a;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #f56565; padding: 12px 24px; border-radius: 8px; margin: 0 auto 20px auto; width: fit-content; color: #ffffff; font-weight: bold; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #c53030;">
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label wajib-isi">Username</label>
                    <input type="text" name="username" class="form-input" placeholder="Masukkan Username" value="{{ old('username') }}" required autofocus
                    oninvalid="this.setCustomValidity('Harap isi semua data')"
                    oninput="this.setCustomValidity('')">
                </div>

                <div class="form-group">
                    <label class="form-label wajib-isi">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan Password" required
                        oninvalid="this.setCustomValidity('Harap isi semua data')"
                        oninput="this.setCustomValidity('')">

                        <button type="button" class="password-toggle" id="passwordToggle">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/>
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
                                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
                                <path d="m2 2 20 20"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <a href="{{ route('password.request') }}" class="forgot-link">Ubah Password?</a>

                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
