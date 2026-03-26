<x-layouts.premium>
    <x-slot:headerTitle>Absensi Digital</x-slot:headerTitle>

    @push('styles')
    <style>
        .card-premium {
            border-radius: 28px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-action {
            padding: 1.25rem;
            border-radius: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-action:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-masuk {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }

        .btn-pulang {
            background: linear-gradient(135deg, #f43f5e, #e11d48);
            box-shadow: 0 10px 20px -5px rgba(244, 63, 94, 0.4);
        }

        .btn-action:hover:not(:disabled) {
            transform: translateY(-3px);
            filter: brightness(1.1);
        }

        .history-item {
            background: rgba(255, 255, 255, 0.02);
            border-left: 4px solid transparent;
            margin-bottom: 0.75rem;
            padding: 1rem;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        #camera-container {
            background: #000;
        }
    </style>
    @endpush

    <div class="max-w-md mx-auto space-y-6 pt-4 px-4 md:px-0">
        <!-- Header Profile -->
        <header class="flex justify-between items-center p-2">
            <div class="flex items-center gap-4">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-14 h-14 rounded-2xl border-2 border-indigo-500/30 object-cover shadow-lg">
                @else
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-xl shadow-lg">
                        👋
                    </div>
                @endif
                <div>
                    <h2 class="text-lg font-bold tracking-tight">{{ explode(' ', auth()->user()->name)[0] }}</h2>
                    <p class="text-indigo-300/60 text-xs font-medium uppercase tracking-widest">{{ auth()->user()->department }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
            <div class="flex items-center gap-2">
                <button @click="sidebarOpen = true" class="md:hidden w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('profile-modal').style.display='flex'" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                    <button type="submit" class="w-10 h-10 glass rounded-xl flex items-center justify-center text-rose-400 hover:bg-rose-500/10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
            </form>
        </header>

        <!-- Profile Edit Modal Extra Fields -->
        <div id="profile-modal" class="fixed inset-0 z-[200] bg-black/80 backdrop-blur-md hidden items-center justify-center p-4">
            <div class="glass max-w-lg w-full rounded-[40px] p-8 shadow-2xl ring-1 ring-white/10 animate-in fade-in zoom-in duration-300 overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-bold tracking-tight text-white">Profil Saya</h3>
                        <p class="text-xs text-indigo-300/50 mt-1 uppercase tracking-widest font-bold">Update informasi pribadi</p>
                    </div>
                    <button onclick="document.getElementById('profile-modal').style.display='none'" class="w-10 h-10 rounded-full glass flex items-center justify-center text-indigo-300/50 hover:text-white transition">&times;</button>
                </div>
                
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Avatar Upload -->
                    <div class="flex flex-col items-center gap-4 mb-4">
                        <div class="relative group">
                            @if(auth()->user()->profile_photo_path)
                                <img id="modal-preview" src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-24 h-24 rounded-3xl border-4 border-white/5 object-cover">
                                <button type="button" onclick="deletePhoto()" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center shadow-lg hover:bg-rose-600 transition border-2 border-[#1e1b4b]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @else
                                <div id="modal-preview-placeholder" class="w-24 h-24 rounded-3xl bg-indigo-500/10 border-4 border-white/5 flex items-center justify-center text-4xl">📸</div>
                            @endif
                            <label class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-3xl opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                <span class="text-[10px] font-bold text-white uppercase tracking-widest">Ubah Foto</span>
                                <input type="file" name="profile_photo" class="hidden" onchange="previewFile(this)">
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Nomor WhatsApp</label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone }}" placeholder="08xxxx" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-indigo-300/50 uppercase tracking-widest mb-2 ml-1">Alamat Rumah</label>
                        <textarea name="address" rows="2" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white">{{ auth()->user()->address }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-white/5 client-border space-y-4">
                        <label class="block text-[10px] font-bold text-indigo-400 uppercase tracking-widest ml-1">Keamanan (Ganti Password)</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="password" name="password" placeholder="Password Baru" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white">
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi" class="w-full glass rounded-2xl px-4 py-4 text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-white">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-5 rounded-[22px] text-sm transition shadow-xl shadow-indigo-600/20 active:scale-95">
                        PERBARUI PROFIL SAYA
                    </button>
                </form>
            </div>
        </div>


        <!-- Clock Card -->
        <div class="glass card-premium text-center border-indigo-500/20 shadow-2xl">
            <div id="clock" class="text-5xl font-bold tracking-tighter mb-1 text-white">00:00:00</div>
            <div id="date" class="text-sm font-medium text-indigo-300/60">...</div>
        </div>

        <!-- Camera Section -->
        <section class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-bold uppercase tracking-widest text-indigo-200/50">Sistem Verifikasi</h3>
                <span id="sync-status" class="text-[10px] text-emerald-400 font-bold bg-emerald-500/10 px-2 py-1 rounded-full animate-pulse">LIVE CONNECTED</span>
            </div>
            
            <div id="camera-container" class="relative glass rounded-[32px] overflow-hidden aspect-[4/3] ring-1 ring-white/10 shadow-2xl">
                <video id="video" autoplay playsinline class="w-full h-full object-cover"></video>
                <canvas id="canvas" class="hidden"></canvas>
                
                <!-- Snapshot Preview Overlay -->
                <div id="snapshot-preview" class="hidden absolute inset-0 bg-black z-20">
                    <img id="preview-img" class="w-full h-full object-cover">
                    <button id="btn-retake" class="absolute bottom-6 right-6 bg-rose-500 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg">FOTO ULANG</button>
                </div>

                <!-- Loading Overlay -->
                <div id="camera-loading" class="absolute inset-0 glass z-10 flex flex-col items-center justify-center gap-4">
                    <div class="w-12 h-12 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
                    <span class="text-xs font-bold tracking-widest text-indigo-300/60 uppercase">Mengaktifkan Vision...</span>
                </div>

                <!-- Scanning Graphic -->
                <div class="absolute inset-0 pointer-events-none border-[20px] border-transparent ring-1 ring-inset ring-indigo-500/20"></div>
                <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-indigo-500 to-transparent animate-bounce translate-y-20 opacity-30"></div>
            </div>

            <button id="btn-snapshot" class="w-full glass py-4 rounded-2xl text-sm font-bold text-indigo-200 hover:bg-indigo-500/10 transition border-indigo-500/10">
                📷 AMBIL SELFIE (CHECKPOINT)
            </button>
        </section>

        <!-- Status & Action Card -->
        <div id="status-card" class="glass card-premium shadow-2xl border-white/5">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-lg">📍</div>
                <div class="flex-1">
                    <h4 id="label-status" class="font-bold text-indigo-200">Mencari Koordinat...</h4>
                    <p id="detail-jarak" class="text-xs text-indigo-300/50 mt-1">Mengakses sensor GPS untuk verifikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button id="btn-absen" class="btn-action btn-masuk text-white text-sm" disabled>
                    ABSEN MASUK
                </button>
                <button id="btn-pulang" class="btn-action btn-pulang text-white text-sm" disabled>
                    PULANG
                </button>
            </div>
            <p id="info-pulang" class="text-center text-[10px] text-rose-400 font-bold mt-4 uppercase hidden"></p>
        </div>

        <!-- History Log -->
        <section class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-widest text-indigo-200/50 px-2">Aktivitas Hari Ini</h3>
            <div id="log-absensi" class="space-y-3 pb-10">
                <div class="history-item glass opacity-50 justify-center py-8 text-center">
                    <span class="text-xs font-bold tracking-widest uppercase">Memuat Log Aktivitas...</span>
                </div>
            </div>
        </section>

        <!-- Hidden Inputs for logic -->
        <input type="hidden" id="user-lat">
        <input type="hidden" id="user-lng">
    </div>

    @push('scripts')
    <script>
        function previewFile(input) {
            const preview = document.getElementById('modal-preview') || 
                          document.getElementById('modal-preview-placeholder');
            const file = input.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                if (preview.tagName === 'IMG') {
                    preview.src = reader.result;
                } else {
                    const img = document.createElement('img');
                    img.id = 'modal-preview';
                    img.src = reader.result;
                    img.className = 'w-24 h-24 rounded-3xl border-4 border-white/5 object-cover';
                    preview.replaceWith(img);
                }
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        async function deletePhoto() {
            if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) return;
            document.getElementById('delete-photo-form').submit();
        }
    </script>
    
    <form id="delete-photo-form" action="{{ route('profile.photo.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // Inline Toast Notification (overriding default showToast if needed)
        window.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif
        });
    </script>
    @endpush
</x-layouts.premium>
