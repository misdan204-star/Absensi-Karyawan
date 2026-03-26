<x-layouts.premium>
    <x-slot:headerTitle>Form Progres Pekerjaan</x-slot:headerTitle>

    <div class="max-w-xl mx-auto space-y-6 pt-4 px-4 md:px-0">
        <header class="flex justify-between items-center p-2">
            <div class="flex items-center gap-4">
                <a href="{{ route('field-work.index') }}" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Laporan Baru</h2>
                    <p class="text-indigo-300/60 text-xs font-medium uppercase tracking-widest">Pekerjaan Lapangan</p>
                </div>
            </div>
        </header>

        <div class="glass card-premium shadow-2xl border-white/5 p-6">
            <form action="{{ route('field-work.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Nama Pekerjaan</label>
                        <input type="text" name="work_name" placeholder="Contoh: Instalasi Server" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Lokasi Pekerjaan</label>
                        <input type="text" name="location" placeholder="Contoh: Gedung A Lt. 3" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Tanggal</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Deskripsi Pekerjaan</label>
                        <textarea name="description" rows="4" placeholder="Jelaskan detail pekerjaan yang dilakukan..." class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Foto Sebelum</label>
                            <div class="relative group aspect-video glass rounded-2xl overflow-hidden flex items-center justify-center border border-white/5">
                                <img id="preview-before" class="hidden absolute inset-0 w-full h-full object-cover">
                                <div id="placeholder-before" class="flex flex-col items-center gap-2 text-indigo-300/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-[10px] uppercase font-bold tracking-widest">Pilih Foto</span>
                                </div>
                                <input type="file" name="photo_before" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, 'preview-before', 'placeholder-before')">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Foto Sesudah</label>
                            <div class="relative group aspect-video glass rounded-2xl overflow-hidden flex items-center justify-center border border-white/5">
                                <img id="preview-after" class="hidden absolute inset-0 w-full h-full object-cover">
                                <div id="placeholder-after" class="flex flex-col items-center gap-2 text-indigo-300/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-[10px] uppercase font-bold tracking-widest">Pilih Foto</span>
                                </div>
                                <input type="file" name="photo_after" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, 'preview-after', 'placeholder-after')">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-5 rounded-[22px] text-sm transition shadow-xl shadow-indigo-600/20 active:scale-95">
                    SIMPAN LAPORAN KERJA
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input, previewId, placeholderId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const file = input.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
    @endpush
</x-layouts.premium>
