<x-layouts.premium>
    <x-slot:headerTitle>Riwayat Pekerjaan Lapangan</x-slot:headerTitle>

    <div class="max-w-xl mx-auto space-y-6 pt-4 px-4 md:px-0">
        <header class="flex justify-between items-center p-2">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-xl shadow-lg">
                    🏗️
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Progres Lapangan</h2>
                    <p class="text-indigo-300/60 text-xs font-medium uppercase tracking-widest">Daftar Laporan Pekerjaan</p>
                </div>
            </div>
            
            @if(auth()->user()->role !== 'admin')
            <a href="{{ route('field-work.create') }}" class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-600/30 hover:bg-indigo-500 transition active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
            @endif
        </header>

        <div class="space-y-4 pb-20">
            @forelse($reports as $report)
            <div class="glass card-premium shadow-xl border-white/5 relative overflow-hidden group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl overflow-hidden shadow-lg border border-white/10 shrink-0">
                        @if($report->photo_before)
                            <img src="{{ asset('storage/' . $report->photo_before) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-500/10 flex items-center justify-center text-xl">📸</div>
                        @endif
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-indigo-100 truncate pr-4">{{ $report->work_name }}</h4>
                            <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest whitespace-nowrap">{{ \Carbon\Carbon::parse($report->date)->format('d M Y') }}</span>
                        </div>
                        <p class="text-xs text-indigo-300/50 mt-1 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $report->location }}
                        </p>
                        @if(auth()->user()->role === 'admin')
                        <p class="text-[10px] font-bold text-purple-400 mt-2 uppercase tracking-widest">Oleh: {{ $report->user->name }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-white/5">
                    <a href="{{ route('field-work.show', $report) }}" class="flex-1 bg-white/5 hover:bg-white/10 text-xs font-bold py-3 rounded-xl text-center text-indigo-200 transition">
                        LIHAT DETAIL
                    </a>
                    @if(auth()->user()->role === 'admin' || $report->user_id === auth()->id())
                    <form action="{{ route('field-work.destroy', $report) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-12 bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 py-3 rounded-xl transition flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="glass card-premium py-16 text-center opacity-50 border-white/5">
                <div class="text-4xl mb-4 text-white/20">📅</div>
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-300">Belum ada laporan pekerjaan</p>
                <p class="text-[10px] mt-2 text-indigo-300/30">Laporan yang sudah dibuat akan muncul di sini</p>
            </div>
            @endforelse
        </div>
    </div>
</x-layouts.premium>
