<x-layouts.premium>
    <x-slot:headerTitle>Admin Dashboard</x-slot:headerTitle>

    @push('styles')
    <style>
        /* === Glass Cards === */
        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover {
            border-color: rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* === Stat Cards === */
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        }
        .stat-card.blue { border-left: 3px solid rgba(167, 139, 250, 0.4); }
        .stat-card.green { border-left: 3px solid rgba(110, 231, 183, 0.4); }
        .stat-card.amber { border-left: 3px solid rgba(252, 211, 77, 0.4); }
        .stat-card.rose { border-left: 3px solid rgba(253, 164, 175, 0.4); }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .stat-icon.blue { background: rgba(167, 139, 250, 0.1); color: #c4b5fd; }
        .stat-icon.green { background: rgba(110, 231, 183, 0.1); color: #6ee7b7; }
        .stat-icon.amber { background: rgba(252, 211, 77, 0.1); color: #fcd34d; }
        .stat-icon.rose { background: rgba(253, 164, 175, 0.1); color: #fda4af; }

        .stat-value {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1;
            background: linear-gradient(135deg, #fff, rgba(255,255,255,0.6));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* === Table === */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .data-table thead th {
            padding: 16px 20px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            text-align: left;
        }
        .data-table tbody td {
            padding: 16px 20px;
            font-size: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
            color: rgba(255, 255, 255, 0.7);
        }

        /* === Badges === */
        .badge {
            padding: 5px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge.masuk {
            background: rgba(52, 211, 153, 0.1);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, 0.2);
        }
        .badge.pulang {
            background: rgba(251, 146, 60, 0.1);
            color: #fdba74;
            border: 1px solid rgba(251, 146, 60, 0.2);
        }
        .badge.pending {
            background: rgba(244, 63, 94, 0.1);
            color: #fda4af;
            border: 1px solid rgba(244, 63, 94, 0.2);
        }

        /* === Dept Bar === */
        .dept-bar {
            height: 6px;
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.03);
            overflow: hidden;
        }
        .dept-bar-fill {
            height: 100%;
            border-radius: 100px;
            background: linear-gradient(90deg, #818cf8, #d8b4fe);
            box-shadow: 0 0 10px rgba(129, 140, 248, 0.3);
        }

        /* === Action Buttons === */
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .action-btn.primary {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white;
        }
        .action-btn.ghost {
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* === Photo Hover === */
        .photo-thumb {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .photo-thumb:hover {
            transform: scale(2.5);
            z-index: 100;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        /* === Live Dot === */
        .live-dot {
            width: 8px; height: 8px;
            background: #34d399;
            border-radius: 50%;
            animation: live-pulse 2s infinite;
        }
        @keyframes live-pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .fade-up {
            animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-2 { animation-delay: 0.2s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
    @endpush

    @push('top_actions')
    <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
        <div class="live-dot"></div>
        <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Live System</span>
    </div>
    @endpush

    <div class="p-6 lg:p-10 space-y-10">
        <!-- ====== STAT CARDS ====== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 fade-up">
            <div class="glass-card stat-card blue p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="stat-icon blue">👥</div>
                    <span class="text-[10px] font-bold text-indigo-400 bg-indigo-500/10 px-3 py-1.5 rounded-full uppercase tracking-widest">Total Staff</span>
                </div>
                <div class="stat-value">{{ $totalEmployees }}</div>
                <p class="text-[11px] text-white/20 font-medium mt-1.5 uppercase tracking-wider">Karyawan Terdaftar</p>
            </div>

            <div class="glass-card stat-card green p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="stat-icon green">✅</div>
                    <span class="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-3 py-1.5 rounded-full uppercase tracking-widest">Present</span>
                </div>
                <div class="stat-value">{{ $attendedToday }}</div>
                <p class="text-[11px] text-white/20 font-medium mt-1.5 uppercase tracking-wider">Sudah Hadir</p>
            </div>

            <div class="glass-card stat-card amber p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="stat-icon amber">⏳</div>
                    <span class="text-[10px] font-bold text-amber-400 bg-amber-500/10 px-3 py-1.5 rounded-full uppercase tracking-widest">Waiting</span>
                </div>
                <div class="stat-value">{{ $absentToday }}</div>
                <p class="text-[11px] text-white/20 font-medium mt-1.5 uppercase tracking-wider">Belum Absen</p>
            </div>

            <div class="glass-card stat-card rose p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="stat-icon rose">📝</div>
                    <span class="badge {{ $pendingLeaves > 0 ? 'pending' : 'masuk' }}">{{ $pendingLeaves > 0 ? 'Review Needed' : 'All Clear' }}</span>
                </div>
                <div class="stat-value">{{ $pendingLeaves }}</div>
                <p class="text-[11px] text-white/20 font-medium mt-1.5 uppercase tracking-wider">Pengajuan Izin</p>
            </div>
        </div>

        <!-- ====== MIDDLE SECTION ====== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 fade-up delay-2">
            <!-- Distribution -->
            <div class="lg:col-span-2 glass-card p-8">
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-white/90">Sebaran Departemen</h3>
                    <p class="text-sm text-white/30 font-medium mt-1">Distribusi karyawan aktif per departemen</p>
                </div>
                <div class="space-y-6">
                    @php $maxCount = $deptStats->max('count') ?: 1; @endphp
                    @foreach($deptStats as $stat)
                    <div class="group">
                        <div class="flex justify-between items-center mb-2.5">
                            <span class="text-sm font-semibold text-white/70 group-hover:text-white transition-colors">{{ $stat->department ?? 'General' }}</span>
                            <span class="text-xs font-bold text-indigo-400">{{ $stat->count }} Person</span>
                        </div>
                        <div class="dept-bar">
                            <div class="dept-bar-fill transition-all duration-1000 ease-out" style="width: {{ ($stat->count / $maxCount) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-card p-8 flex flex-col">
                <h3 class="text-lg font-bold text-white/90 mb-6">Aksi Cepat Admin</h3>
                <div class="space-y-4 flex-1">
                    <a href="{{ route('admin.users.create') }}" class="action-btn primary w-full justify-center py-4 rounded-2xl shadow-xl shadow-indigo-600/20">
                        ➕ Tambah Karyawan Baru
                    </a>
                    <a href="{{ route('admin.export') }}" class="action-btn ghost w-full justify-center py-4 rounded-2xl">
                        📥 Download Laporan CSV
                    </a>
                    <a href="{{ route('admin.leave.index') }}" class="action-btn ghost w-full justify-center py-4 rounded-2xl relative">
                        📋 Kelola Pengajuan Izin
                        @if($pendingLeaves > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white shadow-lg ring-2 ring-black">{{ $pendingLeaves }}</span>
                        @endif
                    </a>
                </div>
                <div class="mt-8 pt-8 border-t border-white/5">
                    <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest text-center">System Version 2.1.0-Premium</p>
                </div>
            </div>
        </div>

        <!-- ====== TABLE SECTION ====== -->
        <div class="glass-card overflow-hidden fade-up delay-4">
            <div class="p-8 pb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-white/90 tracking-tight">Log Absensi Terbaru</h3>
                    <p class="text-sm text-white/30 font-medium mt-1">Real-time update aktivitas kehadiran karyawan</p>
                </div>
            </div>
            
            <div class="overflow-x-auto custom-scrollbar">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Identitas</th>
                            <th>Info Kerja</th>
                            <th>Status/Tipe</th>
                            <th>Waktu Presensi</th>
                            <th>Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td>
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        @if($attendance->image_path)
                                            <img src="{{ asset('storage/' . $attendance->image_path) }}" class="w-12 h-12 object-cover rounded-2xl ring-2 ring-white/5 photo-thumb" alt="Selfie">
                                        @else
                                            <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-white/10 text-xs">NO IMG</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-white/90 leading-tight">{{ $attendance->user->name }}</div>
                                        <div class="text-[10px] font-mono text-white/30 mt-0.5 mt-1 tracking-wider uppercase">{{ $attendance->user->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm font-semibold text-white/60">{{ $attendance->user->department ?? '-' }}</div>
                                <div class="text-[10px] text-white/30 uppercase mt-0.5">Department</div>
                            </td>
                            <td>
                                <span class="badge {{ $attendance->tipe_absen == 'masuk' ? 'masuk' : 'pulang' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $attendance->tipe_absen == 'masuk' ? 'bg-emerald-400' : 'bg-orange-400' }}"></span>
                                    {{ strtoupper($attendance->tipe_absen) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-sm font-bold text-white/80 leading-tight">{{ $attendance->created_at->format('H:i') }} <span class="text-[10px] font-normal text-white/30 ml-0.5">WIB</span></div>
                                <div class="text-[10px] text-white/30 mt-1 uppercase font-semibold leading-tight tracking-wider">{{ $attendance->created_at->locale('id')->translatedFormat('d M Y') }}</div>
                            </td>
                            <td>
                                <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" target="_blank" class="p-2.5 rounded-xl bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 transition-all inline-flex items-center gap-2 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span class="text-[11px] font-bold font-mono tracking-tighter">VIEW MAP</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 rounded-3xl bg-white/5 flex items-center justify-center text-4xl mb-2">📥</div>
                                    <p class="text-sm text-white/30 font-bold uppercase tracking-widest tracking-widest">Belum ada data presensi hari ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-white/5 bg-black/20">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</x-layouts.premium>
