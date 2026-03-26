<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi Digital Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top right, #2e1065, #020617);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Background Animated Blobs */
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.4;
            animation: move 20s infinite alternate;
        }
        .blob-2 {
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
            width: 400px;
            height: 400px;
            right: -100px;
            bottom: -100px;
            animation-delay: -5s;
        }

        @keyframes move {
            from { transform: translate(-10%, -10%) rotate(0deg); }
            to { transform: translate(10%, 10%) rotate(360deg); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            width: 100%;
            max-width: 420px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-group input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
            background: rgba(255, 255, 255, 0.08) !important;
        }

        .btn-premium {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(99, 102, 241, 0.5);
            filter: brightness(1.1);
        }

        .btn-premium:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="blob"></div>
    <div class="blob blob-2"></div>

    <div class="glass-card">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 mb-4">
                <span class="text-3xl">📡</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-white mb-2">Selamat Datang</h1>
            <p class="text-indigo-200/50 text-sm">Masuk untuk mengelola absensi Anda</p>
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-4 font-medium text-sm text-green-400 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="input-group">
                <label class="block text-xs font-semibold text-indigo-200/50 uppercase tracking-wider mb-2">Alamat Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                    class="w-full px-4 py-4 rounded-2xl text-sm focus:outline-none" placeholder="nama@perusahaan.com">
                @if($errors->has('email'))
                    <p class="mt-2 text-xs text-rose-400 italic">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password -->
            <div class="input-group">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold text-indigo-200/50 uppercase tracking-wider">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition">Lupa?</a>
                    @endif
                </div>
                <input id="password" type="password" name="password" required 
                    class="w-full px-4 py-4 rounded-2xl text-sm focus:outline-none" placeholder="••••••••">
                @if($errors->has('password'))
                    <p class="mt-2 text-xs text-rose-400 italic">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="hidden">
                    <div class="w-5 h-5 border-2 border-indigo-500/30 rounded-lg flex items-center justify-center transition-all group-hover:border-indigo-500">
                        <div class="w-2.5 h-2.5 bg-indigo-500 rounded-sm opacity-0 transition-opacity check-mark"></div>
                    </div>
                    <span class="ms-3 text-sm text-indigo-200/60 group-hover:text-indigo-200 transition">Ingat Saya</span>
                </label>
            </div>

            <div>
                <button type="submit" class="w-full btn-premium text-white font-bold py-4 rounded-2xl text-sm tracking-wide">
                    MASUK SEKARANG
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-xs text-indigo-200/30">
            &copy; 2026 Absensi Digital Modern. <br> Protected by Enterprise Security.
        </p>
    </div>

    <script>
        // Custom checkbox toggle
        const checkboxContainer = document.querySelector('.group');
        const checkMark = document.querySelector('.check-mark');
        const input = document.querySelector('input[type="checkbox"]');

        checkboxContainer.addEventListener('click', () => {
            input.checked = !input.checked;
            checkMark.style.opacity = input.checked ? '1' : '0';
        });
    </script>
</body>
</html>
