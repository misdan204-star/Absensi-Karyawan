<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Staff - GPS Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at bottom left, #1e1b4b, #020617);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow-x: hidden;
        }

        .blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            filter: blur(100px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.2;
            top: -10%;
            right: -10%;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 40px;
            width: 100%;
            max-width: 500px;
            padding: 3.5rem;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.6);
        }

        input {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: white !important;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #818cf8 !important;
            box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.1) !important;
            background: rgba(255, 255, 255, 0.05) !important;
            outline: none;
        }

        .btn-register {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-register:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 30px -10px rgba(79, 70, 229, 0.4);
        }
    </style>
</head>
<body>
    <div class="blob"></div>

    <div class="glass-card">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-white mb-3">REGISTRASI STAFF</h1>
            <p class="text-indigo-300/40 text-[10px] font-bold uppercase tracking-[0.3em]">Bergabung dengan Ekosistem Digital Kami</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-[10px] font-bold text-indigo-300/30 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-5 py-4 rounded-2xl text-sm" placeholder="Contoh: John Doe" required autofocus>
                @if($errors->has('name')) <p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $errors->first('name') }}</p> @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/30 uppercase tracking-widest mb-2 ml-1">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="w-full px-5 py-4 rounded-2xl text-sm" placeholder="2024..." required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/30 uppercase tracking-widest mb-2 ml-1">Departemen</label>
                    <input type="text" name="department" value="{{ old('department') }}" class="w-full px-5 py-4 rounded-2xl text-sm" placeholder="IT, HR, dll" required>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-indigo-300/30 uppercase tracking-widest mb-2 ml-1">Email Perusahaan</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-5 py-4 rounded-2xl text-sm" placeholder="staff@perusahaan.com" required>
                @if($errors->has('email')) <p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $errors->first('email') }}</p> @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/30 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <input type="password" name="password" class="w-full px-5 py-4 rounded-2xl text-sm" placeholder="••••••••" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/30 uppercase tracking-widest mb-2 ml-1">Konfirmasi</label>
                    <input type="password" name="password_confirmation" class="w-full px-5 py-4 rounded-2xl text-sm" placeholder="••••••••" required>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full btn-register text-white font-bold py-5 rounded-2xl text-xs tracking-[0.2em] shadow-lg">DAFTAR SEKARANG</button>
            </div>

            <div class="text-center pt-6">
                <a href="{{ route('login') }}" class="text-xs text-indigo-300/40 hover:text-indigo-300 transition uppercase tracking-widest font-bold">Sudah punya akun? Masuk</a>
            </div>
        </form>
    </div>
</body>
</html>
