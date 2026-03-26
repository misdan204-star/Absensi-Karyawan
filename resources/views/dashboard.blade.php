<x-layouts.premium>
    <x-slot:headerTitle>Beranda</x-slot:headerTitle>

    <div class="p-6 lg:p-10">
        <div class="glass p-12 rounded-[40px] text-center border-white/5 shadow-2xl">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-[32px] bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-white/10 mb-8 shadow-inner">
                <span class="text-5xl">👋</span>
            </div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-4">Selamat Datang Kembali!</h1>
            <p class="text-indigo-200/50 text-lg max-w-lg mx-auto leading-relaxed">
                Anda telah berhasil masuk ke sistem <strong>GPS Attendance Premium</strong>. Silakan gunakan menu di samping untuk mulai mengelola absensi atau pengajuan izin Anda.
            </p>
            
            <div class="mt-12 flex flex-wrap justify-center gap-6">
                <a href="{{ route('absensi') }}" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-bold transition shadow-xl shadow-indigo-600/20 active:scale-95">Buka Absensi</a>
                <a href="{{ route('leave.index') }}" class="px-10 py-4 glass hover:bg-white/10 text-white rounded-2xl font-bold transition">Riwayat Izin</a>
            </div>
        </div>
    </div>
</x-layouts.premium>
