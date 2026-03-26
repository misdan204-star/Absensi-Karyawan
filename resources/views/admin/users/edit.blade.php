<x-layouts.premium>
    <x-slot:headerTitle>Edit Data Karyawan</x-slot:headerTitle>

    <div class="max-w-2xl mx-auto p-6 lg:p-10">
        <div class="mb-10">
            <h1 class="text-3xl font-bold tracking-tight text-white mb-2 text-center">EDIT PROFILE STAFF</h1>
            <p class="text-orange-400 font-medium tracking-wide opacity-80 uppercase text-xs text-center">Perbarui Informasi Karyawan: {{ $user->name }}</p>
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

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="glass p-10 space-y-8 rounded-[40px] shadow-2xl border-white/5">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">NIK (Nomor Induk Karyawan)</label>
                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Departemen / Divisi</label>
                        <input type="text" name="department" value="{{ old('department', $user->department) }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Password Baru (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Role / Hak Akses</label>
                        <select name="role" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition appearance-none" required>
                            <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee (Karyawan)</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator (Manager)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 py-5 rounded-2xl font-bold shadow-xl shadow-orange-500/20 active:scale-95 transition text-sm tracking-widest uppercase">Perbarui Data</button>
                <a href="{{ route('admin.users.index') }}" class="px-10 py-5 glass hover:bg-white/10 rounded-2xl font-bold transition text-sm tracking-widest text-white/50 hover:text-white uppercase flex items-center">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.premium>
