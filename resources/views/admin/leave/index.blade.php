<x-layouts.premium>
    <x-slot:headerTitle>Verifikasi Izin & Cuti</x-slot:headerTitle>

    @push('styles')
    <style>
        .badge-status {
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-sakit { background: rgba(244, 63, 94, 0.1); color: #fda4af; border: 1px solid rgba(244, 63, 94, 0.2); }
        .badge-cuti { background: rgba(59, 130, 246, 0.1); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.2); }
        .badge-izin { background: rgba(245, 158, 11, 0.1); color: #fcd34d; border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge-dinas { background: rgba(16, 185, 129, 0.1); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.2); }

        .btn-verify {
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 10px;
            font-bold: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
    </style>
    @endpush

    <div class="p-6 lg:p-10 space-y-8">
        <div class="bg-white/[0.02] p-8 rounded-[32px] border border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-xl font-bold text-white tracking-tight">VERIFIKASI PENGAJUAN</h3>
                <p class="text-xs text-indigo-300/50 uppercase font-bold tracking-widest mt-1">Kelola perizinan & ketidakhadiran staff</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em]">Total Pengajuan:</span>
                <span class="bg-indigo-500/10 text-indigo-400 px-4 py-1 rounded-full text-xs font-bold border border-indigo-500/20">{{ $requests->total() }}</span>
            </div>
        </div>

        <div class="glass overflow-hidden rounded-[32px] border-white/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest">Karyawan</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest">Tipe & Periode</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest">Alasan & Lampiran</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest text-center">Status / Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $req)
                        <tr class="border-b border-white/5 hover:bg-white/[0.01] transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-xl flex items-center justify-center font-bold text-indigo-300 text-sm border border-white/5">
                                        {{ strtoupper(substr($req->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white/90 leading-tight">{{ $req->user->name }}</div>
                                        <div class="text-[11px] text-white/30 mt-1 uppercase tracking-wider">{{ $req->user->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <span class="badge-status {{ 'badge-'.$req->type }}">
                                    {{ $req->type }}
                                </span>
                                <div class="text-[11px] font-bold text-white/40 mt-2 tracking-tight">
                                    {{ \Carbon\Carbon::parse($req->start_date)->format('d M') }} — {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <p class="text-sm text-white/70 leading-relaxed font-medium mb-2">
                                    {{ Str::limit($req->reason, 80) }}
                                </p>
                                @if($req->evidence_path)
                                    <a href="{{ asset('storage/' . $req->evidence_path) }}" target="_blank" class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-2 uppercase tracking-widest group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                        Lihat Bukti Foto
                                    </a>
                                @endif
                            </td>
                            <td class="py-6 px-8">
                                <div class="flex justify-center gap-2">
                                    @if($req->status == 'pending')
                                        <form action="{{ route('admin.leave.status', $req) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button class="btn-verify bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.leave.status', $req) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="btn-verify bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white">Reject</button>
                                        </form>
                                    @else
                                        <div class="px-6 py-2 rounded-xl text-[10px] font-extrabold uppercase tracking-widest {{ $req->status == 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-500 border border-rose-500/20' }}">
                                            {{ $req->status }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-24 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-20">
                                    <span class="text-5xl">📄</span>
                                    <p class="text-xs font-bold uppercase tracking-widest">Tidak ada pengajuan terbengkalai</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-8 bg-black/20 border-t border-white/5">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</x-layouts.premium>
