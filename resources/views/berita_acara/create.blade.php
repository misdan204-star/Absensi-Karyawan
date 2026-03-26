<x-layouts.premium>
    <x-slot:headerTitle>Buat Berita Acara</x-slot:headerTitle>

    <div class="max-w-xl mx-auto space-y-6 pt-4 px-4 md:px-0">
        <header class="flex justify-between items-center p-2">
            <div class="flex items-center gap-4">
                <a href="{{ route('field-work.show', $report) }}" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Dokumen Baru</h2>
                    <p class="text-indigo-300/60 text-xs font-medium uppercase tracking-widest">Berita Acara Pekerjaan</p>
                </div>
            </div>
        </header>

        <div class="glass card-premium shadow-2xl border-white/5 p-6">
            <form action="{{ route('berita-acara.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="field_work_report_id" value="{{ $report->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Nomor Berita Acara (Otomatis)</label>
                        <input type="text" name="ba_number" value="{{ $ba_number }}" readonly class="w-full glass rounded-2xl px-4 py-4 text-sm bg-white/5 border-none text-indigo-200 cursor-not-allowed uppercase font-bold tracking-wider">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Nama Klien / Perusahaan</label>
                        <input type="text" name="client_name" placeholder="Contoh: PT. Maju Bersama" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Tanggal Dokumen</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5 space-y-3">
                        <span class="block text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Informasi Pekerjaan Terkait</span>
                        <div class="text-xs text-indigo-100 flex flex-col gap-1">
                            <p class="font-bold">{{ $report->work_name }}</p>
                            <p class="opacity-50">{{ $report->location }}</p>
                        </div>
                    </div>

                    <div class="pt-4">
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-4 ml-1 text-center">Tanda Tangan Digital (Opsional)</label>
                        <div class="relative bg-white/5 rounded-3xl border border-white/10 overflow-hidden">
                            <canvas id="signature-pad" class="w-full h-40 cursor-crosshair"></canvas>
                            <button type="button" id="clear-signature" class="absolute top-4 right-4 text-[10px] font-bold text-rose-400 uppercase tracking-widest bg-rose-500/10 px-3 py-1.5 rounded-full hover:bg-rose-500/20 transition">Bersihkan</button>
                        </div>
                        <input type="hidden" name="signature" id="signature-input">
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-5 rounded-[22px] text-sm transition shadow-xl shadow-indigo-600/20 active:scale-95">
                    GENERATE BERITA ACARA
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: '#ede9fe'
        });

        // Resize canvas correctly
        function resizeCanvas() {
            const ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        document.getElementById('clear-signature').addEventListener('click', () => {
            signaturePad.clear();
        });

        document.getElementById('submit-btn').addEventListener('click', () => {
            if (!signaturePad.isEmpty()) {
                document.getElementById('signature-input').value = signaturePad.toDataURL();
            }
        });
    </script>
    @endpush
</x-layouts.premium>
