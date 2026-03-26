<x-layouts.premium>
    <x-slot:headerTitle>Detail Pekerjaan Lapangan</x-slot:headerTitle>

    <div class="max-w-xl mx-auto space-y-6 pt-4 px-4 md:px-0">
        <header class="flex justify-between items-center p-2">
            <div class="flex items-center gap-4">
                <a href="{{ route('field-work.index') }}" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Detail Laporan</h2>
                    <p class="text-indigo-300/60 text-xs font-medium uppercase tracking-widest">{{ $report->work_name }}</p>
                </div>
            </div>
            
            <button onclick="window.print()" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
            </button>
        </header>

        <div class="glass card-premium shadow-2xl border-white/5 p-6 space-y-8">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <span class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-1">Nama Karyawan</span>
                    <p class="text-sm font-bold text-white">{{ $report->user?->name ?? 'Tidak Diketahui' }}</p>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-1">Tanggal</span>
                    <p class="text-sm font-bold text-white">{{ \Carbon\Carbon::parse($report->date)->format('d F Y') }}</p>
                </div>
            </div>

            <div>
                <span class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-1">Lokasi</span>
                <p class="text-sm font-medium text-indigo-200">{{ $report->location }}</p>
            </div>

            <div>
                <span class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2">Deskripsi Pekerjaan</span>
                <div class="glass bg-white/5 p-4 rounded-2xl text-xs text-indigo-100 leading-relaxed">
                    {{ $report->description }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <span class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest">FOTO SEBELUM</span>
                    <div class="aspect-video glass rounded-2xl overflow-hidden shadow-2xl ring-1 ring-white/10 group cursor-zoom-in" onclick="document.getElementById('modal-photo-before').style.display='flex'">
                        @if($report->photo_before)
                            <img src="{{ asset('storage/' . $report->photo_before) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-indigo-500/10 flex items-center justify-center text-xl">📸</div>
                        @endif
                    </div>
                </div>

                <div class="space-y-3">
                    <span class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest">FOTO SESUDAH</span>
                    <div class="aspect-video glass rounded-2xl overflow-hidden shadow-2xl ring-1 ring-white/10 group cursor-zoom-in" onclick="document.getElementById('modal-photo-after').style.display='flex'">
                        @if($report->photo_after)
                            <img src="{{ asset('storage/' . $report->photo_after) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-indigo-500/10 flex items-center justify-center text-xl">📸</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <a href="{{ route('berita-acara.create', ['report_id' => $report->id]) }}" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-5 rounded-[22px] text-sm transition shadow-xl shadow-purple-600/20 active:scale-95 flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                BUAT BERITA ACARA
            </a>

            @if($report->user_id === auth()->id())
            <form action="{{ route('field-work.destroy', $report) }}" method="POST" id="delete-form-{{ $report->id }}">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDelete('{{ $report->id }}')" class="w-full glass py-4 rounded-2xl text-xs font-bold text-rose-500 hover:bg-rose-500/10 transition border border-rose-500/20 mb-20 uppercase tracking-widest">
                    HAPUS LAPORAN INI
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Modals for Full Size Photos -->
    @if($report->photo_before)
    <div id="modal-photo-before" class="fixed inset-0 z-[300] bg-black/90 backdrop-blur-xl hidden items-center justify-center p-4 cursor-zoom-out" onclick="this.style.display='none'">
        <img src="{{ asset('storage/' . $report->photo_before) }}" class="max-w-full max-h-full rounded-2xl shadow-2xl">
    </div>
    @endif
    @if($report->photo_after)
    <div id="modal-photo-after" class="fixed inset-0 z-[300] bg-black/90 backdrop-blur-xl hidden items-center justify-center p-4 cursor-zoom-out" onclick="this.style.display='none'">
        <img src="{{ asset('storage/' . $report->photo_after) }}" class="max-w-full max-h-full rounded-2xl shadow-2xl">
    </div>
    @endif
    @push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '⚠️ Apakah yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#6366f1',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                background: '#0a0a0f',
                color: '#fff',
                backdrop: 'rgba(0,0,0,0.8)'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
</x-layouts.premium>
