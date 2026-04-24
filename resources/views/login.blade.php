<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman login Seed Track - Sistem manajemen pertanian">
    <title>Login - Seed Track</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        {{-- LEFT PANEL: Form --}}
        <div class="left-panel">
            <img src="{{ asset('images/login+logo.png') }}" alt="Background" class="left-panel-bg">
            <div class="form-heading">
                <h1>Halo Para Staf<br>Tercinta</h1>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="alert-error" id="alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </svg>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                {{-- Username --}}
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-input @error('username') is-invalid @enderror"
                        placeholder="Masukkan Username"
                        value="{{ old('username') }}"
                        required
                        autofocus
                    >
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Masukkan Password"
                            required
                        >
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/>
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
                                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
                                <path d="m2 2 20 20"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="forgot-section">
                    <a href="{{ route('password.request') }}" class="forgot-link">Ubah Password?</a>
                </div>
                <button type="submit" class="btn-login" id="btnLogin">
                    <span>Login</span>
                </button>
            </form>
        </div>

        {{-- RIGHT PANEL: Image (logo sudah ada di gambar) --}}
        <div class="right-panel">
            <img src="{{ asset('images/login+logo.png') }}" alt="Seed Track" class="right-panel-bg">
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
