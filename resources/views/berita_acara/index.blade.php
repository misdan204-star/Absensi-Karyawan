<x-layouts.premium>
    <x-slot:headerTitle>Daftar Berita Acara</x-slot:headerTitle>

    <div class="max-w-xl mx-auto space-y-6 pt-4 px-4 md:px-0">
        <header class="flex justify-between items-center p-2">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-xl shadow-lg">
                    📑
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Berita Acara</h2>
                    <p class="text-indigo-300/60 text-xs font-medium uppercase tracking-widest">Manajemen Dokumen Pekerjaan</p>
                </div>
            </div>
        </header>

        <div class="space-y-4 pb-20">
            @forelse($bas as $ba)
            <div class="glass card-premium shadow-xl border-white/5 relative overflow-hidden group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400 font-bold shrink-0">
                        BA
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-indigo-100 truncate pr-4">{{ $ba->ba_number }}</h4>
                            <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($ba->date)->format('d/m/Y') }}</span>
                        </div>
                        <p class="text-xs text-indigo-100 mt-1 font-medium truncate">{{ $ba->client_name }}</p>
                        <p class="text-[10px] text-indigo-300/40 mt-1 uppercase tracking-widest truncate">{{ $ba->fieldWorkReport->work_name }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-white/5">
                    <a href="{{ route('berita-acara.show', $ba) }}" class="bg-white/5 hover:bg-white/10 text-[10px] font-bold py-3 rounded-xl text-center text-indigo-200 transition">
                        LIHAT DETAIL
                    </a>
                    <a href="{{ route('berita-acara.download', $ba) }}" class="bg-indigo-600/20 hover:bg-indigo-600/30 text-[10px] font-bold py-3 rounded-xl text-center text-indigo-400 transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        DOWNLOAD PDF
                    </a>
                </div>
            </div>
            @empty
            <div class="glass card-premium py-16 text-center opacity-50 border-white/5">
                <div class="text-4xl mb-4 text-white/20">📄</div>
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-300">Belum ada Berita Acara</p>
                <p class="text-[10px] mt-2 text-indigo-300/30">Buat dokumen melalui menu riwayat pekerjaan</p>
                <a href="{{ route('field-work.index') }}" class="inline-block mt-4 text-[10px] text-indigo-400 font-bold hover:underline">KE RIWAYAT PEKERJAAN</a>
            </div>
            @endforelse
        </div>
    </div>
</x-layouts.premium>
