<x-layouts.premium>
    <x-slot:headerTitle>Tambah Karyawan Baru</x-slot:headerTitle>

    <div class="max-w-2xl mx-auto p-6 lg:p-10">
        <div class="mb-10">
            <h1 class="text-3xl font-bold tracking-tight text-white mb-2 text-center">TAMBAH STAFF</h1>
            <p class="text-indigo-400 font-medium tracking-wide opacity-80 uppercase text-xs text-center">Registrasi Karyawan Baru ke dalam Sistem</p>
        </div>

        @if ($errors->any())
            <div class="glass border-rose-500/30 bg-rose-500/10 text-rose-300 p-6 rounded-3xl mb-8">
                <ul class="list-disc pl-5 space-y-1 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="glass p-10 space-y-8 rounded-[40px] shadow-2xl border-white/5">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" placeholder="Masukkan nama lengkap..." required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">NIK (Nomor Induk Karyawan)</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" placeholder="Contoh: 2024001" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Departemen / Divisi</label>
                        <input type="text" name="department" value="{{ old('department') }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" placeholder="Contoh: IT Support">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" placeholder="nama@perusahaan.com" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Password Sistem</label>
                        <input type="password" name="password" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" placeholder="••••••••" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Role / Hak Akses</label>
                        <select name="role" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition appearance-none" required>
                            <option value="employee">Employee (Karyawan)</option>
                            <option value="admin">Administrator (Manager)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 py-5 rounded-2xl font-bold shadow-xl shadow-emerald-500/20 active:scale-95 transition text-sm tracking-widest">SIMPAN KARYAWAN</button>
                <a href="{{ route('admin.users.index') }}" class="px-10 py-5 glass hover:bg-white/10 rounded-2xl font-bold transition text-sm tracking-widest text-white/50 hover:text-white">KEMBALI</a>
            </div>
        </form>
    </div>
</x-layouts.premium>
