<x-layouts.premium>
    <x-slot:headerTitle>Detail Berita Acara</x-slot:headerTitle>

    <div class="max-w-xl mx-auto space-y-6 pt-4 px-4 md:px-0 pb-20">
        <header class="flex justify-between items-center p-2">
            <div class="flex items-center gap-4">
                <a href="{{ route('berita-acara.index') }}" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Preview Dokumen</h2>
                    <p class="text-indigo-300/60 text-xs font-medium uppercase tracking-widest">{{ $beritaAcara->ba_number }}</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('berita-acara.print', $beritaAcara) }}" target="_blank" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </a>
                <a href="{{ route('berita-acara.download', $beritaAcara) }}" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-emerald-400 hover:bg-emerald-500/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
            </div>
        </header>

        <div class="glass card-premium shadow-2xl border-white/5 p-8 bg-white/5 space-y-10">
            <!-- Header BA Style -->
            <div class="flex flex-col items-center gap-6 border-b border-white/10 pb-8">
                <div class="relative w-24 h-24 flex items-center justify-center">
                    <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-2xl" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="nustech-grad-left" x1="15" y1="20" x2="60" y2="85" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#22d3ee" />
                                <stop offset="1" stop-color="#3b82f6" />
                            </linearGradient>
                            <linearGradient id="nustech-grad-right" x1="40" y1="15" x2="85" y2="80" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#1d4ed8" />
                                <stop offset="1" stop-color="#1e3a8a" />
                            </linearGradient>
                        </defs>
                        <path d="M 15 35 L 35 20 L 35 70 L 15 85 Z" fill="url(#nustech-grad-left)" />
                        <line x1="33" y1="40" x2="57" y2="55" stroke="url(#nustech-grad-left)" stroke-width="4" stroke-linecap="round" />
                        <circle cx="61" cy="58" r="4" stroke="url(#nustech-grad-left)" stroke-width="4" fill="#000" />
                        
                        <path d="M 85 65 L 65 80 L 65 30 L 85 15 Z" fill="url(#nustech-grad-right)" />
                        <line x1="67" y1="60" x2="43" y2="45" stroke="url(#nustech-grad-right)" stroke-width="4" stroke-linecap="round" />
                        <circle cx="39" cy="42" r="4" stroke="url(#nustech-grad-right)" stroke-width="4" fill="#000" />
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-bold text-white tracking-widest uppercase mb-1">Berita Acara Pekerjaan</h3>
                    <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">NUSTECH PROFESSIONAL SERVICE</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div>
                        <span class="block text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest mb-1.5">No. Dokumen</span>
                        <p class="text-xs font-bold text-white">{{ $beritaAcara->ba_number }}</p>
                    </div>
                    <div>
                        <span class="block text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest mb-1.5">Identitas Klien</span>
                        <p class="text-xs font-bold text-white">{{ $beritaAcara->client_name }}</p>
                    </div>
                    <div>
                        <span class="block text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest mb-1.5">Pekerjaan Terlaksana</span>
                        <p class="text-xs font-bold text-white leading-relaxed">{{ $beritaAcara->fieldWorkReport->work_name }}</p>
                    </div>
                </div>

                <div class="space-y-6 md:text-right">
                    <div>
                        <span class="block text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest mb-1.5 md:mr-0 mr-auto">Tanggal Pekerjaan</span>
                        <p class="text-xs font-bold text-white">{{ \Carbon\Carbon::parse($beritaAcara->fieldWorkReport->date)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <span class="block text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest mb-1.5 md:mr-0 mr-auto">Lokasi</span>
                        <p class="text-xs font-bold text-indigo-300">{{ $beritaAcara->fieldWorkReport->location }}</p>
                    </div>
                    <div>
                        <span class="block text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest mb-1.5 md:mr-0 mr-auto">Pelaksana</span>
                        <p class="text-xs font-bold text-white">{{ $beritaAcara->fieldWorkReport->user->name }}</p>
                    </div>
                </div>
            </div>

            <div>
                <span class="block text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest mb-4">Uraian Pekerjaan</span>
                <div class="bg-black/20 p-6 rounded-3xl border border-white/5 text-xs text-indigo-100 leading-relaxed font-light italic">
                    "{{ $beritaAcara->fieldWorkReport->description }}"
                </div>
            </div>

            @if($beritaAcara->signature)
            <div class="flex flex-col items-end gap-2 pt-6">
                <span class="text-[8px] font-bold text-indigo-300/40 uppercase tracking-widest text-center w-40">Tanda Tangan Pelaksana</span>
                <div class="w-40 h-24 bg-white/5 rounded-2xl border border-white/10 p-2 flex items-center justify-center overflow-hidden grayscale">
                    <img src="{{ $beritaAcara->signature }}" class="max-w-full max-h-full invert opacity-80">
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.premium>
