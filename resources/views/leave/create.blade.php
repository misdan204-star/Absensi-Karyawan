<x-layouts.premium>
    <x-slot:headerTitle>Form Pengajuan Izin/Cuti</x-slot:headerTitle>

    <div class="max-w-2xl mx-auto p-6 lg:p-10">
        <div class="mb-10">
            <h1 class="text-3xl font-bold tracking-tight text-white mb-2">FORM PENGAJUAN</h1>
            <p class="text-indigo-400 font-medium tracking-wide opacity-80 uppercase text-xs">Silakan isi detail izin/cuti/sakit Anda</p>
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

        <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data" class="glass p-10 space-y-8 rounded-[40px] shadow-2xl border-white/5">
            @csrf
            <div class="group">
                <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Jenis Pengajuan</label>
                <select name="type" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition appearance-none" required>
                    <option value="izin">Izin (Keperluan Mendesak)</option>
                    <option value="cuti">Cuti Tahunan</option>
                    <option value="sakit">Sakit (Butuh Surat Dokter)</option>
                    <option value="dinas">Tugas Luar / Dinas</option>
                    <option value="dispensasi">Dispensasi</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition" required>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Alasan / Keterangan</label>
                <textarea name="reason" rows="4" class="w-full glass p-5 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition resize-none" placeholder="Jelaskan alasan pengajuan Anda secara detail..." required></textarea>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-3 ml-1">Bukti Pendukung (Opsional)</label>
                <div class="glass border-dashed border-white/20 p-8 rounded-2xl text-center hover:bg-white/[0.02] transition-colors cursor-pointer relative group">
                    <input type="file" name="evidence" class="absolute inset-0 opacity-0 cursor-pointer">
                    <span class="text-3xl mb-2 block">📷</span>
                    <p class="text-xs font-bold text-indigo-300/60 uppercase tracking-widest group-hover:text-indigo-300 transition-colors">Klik untuk upload bukti (JPG, PNG)</p>
                </div>
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 py-5 rounded-2xl font-bold shadow-xl shadow-indigo-600/20 active:scale-95 transition text-sm tracking-widest">KIRIM PENGAJUAN</button>
                <a href="{{ route('leave.index') }}" class="px-10 py-5 glass hover:bg-white/10 rounded-2xl font-bold transition text-sm tracking-widest text-white/50 hover:text-white">BATAL</a>
            </div>
        </form>
    </div>
</x-layouts.premium>
