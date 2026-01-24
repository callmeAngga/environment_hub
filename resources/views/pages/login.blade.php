<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Data Lingkungan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <img src="https://images.unsplash.com/photo-1532509854226-a2d9d8e66f8e?q=80&w=687&auto=format&fit=crop"
                alt="Environment" class="bg-image">
            <div class="brand-content">
                <div class="brand-logo-large">
                    <i class="fas fa-leaf"></i>
                </div>
                <h1 class="brand-title-large">Sistem Manajemen<br>Data Lingkungan</h1>
                <p class="brand-subtitle-large">Indofood</p>
            </div>
        </div>
        <div class="login-right">
            <div class="login-header">
                <h2>Selamat Datang</h2>
            </div>
            @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif
            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" required
                            class="form-control"
                            placeholder="Masukan username Anda"
                            value="{{ old('username') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" required
                            class="form-control"
                            placeholder="Masukkan password Anda">

                        <button type="button" onclick="togglePassword()" class="password-toggle">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            <div class="login-footer">
                &copy; {{ date('Y') }} Sistem Manajemen Data Lingkungan. All rights reserved.
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>