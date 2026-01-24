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
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-group">
                        <input type="email" name="email" id="email" required
                            class="form-control"
                            placeholder="Masukan email Anda"
                            value="{{ old('email') }}">
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

<!-- LAMA -->
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Environment Hub</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl flex overflow-hidden leading-relaxed text-gray-800">
        <div class="hidden md:flex md:w-1/2 bg-blue-600 items-center justify-center text-white">
            <img src="https://images.unsplash.com/photo-1532509854226-a2d9d8e66f8e?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Environment Background" class="object-cover h-full w-full">
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Selamat Datang!</h2>
                <p class="text-gray-600 mt-2">Silahkan masuk dengan akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-gray-900 text-sm font-semibold mb-2" for="email">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" required
                        class="shadow-sm border border-gray-300 rounded-xl w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>

                <div class="mb-8">
                    <label class="block text-gray-900 text-sm font-semibold mb-2" for="password">
                        Password
                    </label>
                    
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="shadow-sm border border-gray-300 rounded-xl w-full py-3 px-4 pr-12 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600 focus:outline-none">
                            
                            <svg id="eye-open" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg id="eye-closed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl focus:outline-none focus:shadow-outline transition duration-300 shadow-lg">
                        Sign In
                    </button>
                </div>
            </form>
            
            <p class="text-center text-gray-500 text-xs mt-8">
                &copy;2026 Sistem Manajemen Data Lingkungan. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>
</body>
</html> -->