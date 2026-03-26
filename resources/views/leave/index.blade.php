<x-layouts.premium>
    <x-slot:headerTitle>Riwayat Pengajuan Izin/Cuti</x-slot:headerTitle>

    @push('styles')
    <style>
        .badge-status {
            padding: 6px 16px;
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
        .badge-approved { background: rgba(16, 185, 129, 0.15); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-pending { background: rgba(245, 158, 11, 0.15); color: #fcd34d; border: 1px solid rgba(245, 158, 11, 0.3); }
        .badge-rejected { background: rgba(244, 63, 94, 0.15); color: #fda4af; border: 1px solid rgba(244, 63, 94, 0.3); }
    </style>
    @endpush

    <div class="p-6 lg:p-10 space-y-8">
        <div class="flex justify-between items-center bg-white/[0.02] p-8 rounded-[32px] border border-white/5">
            <div>
                <h3 class="text-xl font-bold text-white tracking-tight">STATUS PENGAJUAN</h3>
                <p class="text-xs text-indigo-300/50 uppercase font-bold tracking-widest mt-1">Riwayat & Hasil Verifikasi</p>
            </div>
            <a href="{{ route('leave.create') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 rounded-2xl font-bold shadow-xl shadow-indigo-600/20 active:scale-95 transition text-xs tracking-widest">
                + AJUKAN BARU
            </a>
        </div>

        <div class="glass overflow-hidden rounded-[32px] border-white/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest">Tipe & Tanggal</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest">Alasan Pengajuan</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest text-center">Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                        <tr class="border-b border-white/5 hover:bg-white/[0.01] transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex flex-col gap-2">
                                    <span class="badge-status w-fit {{ 'badge-'.$request->type }}">
                                        {{ $request->type }}
                                    </span>
                                    <span class="text-xs font-bold text-white/40 tracking-tight">
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <p class="text-sm text-white/70 leading-relaxed font-medium">
                                    {{ Str::limit($request->reason, 60) }}
                                </p>
                            </td>
                            <td class="py-6 px-8 text-center">
                                @if($request->status == 'pending')
                                    <span class="badge-status badge-pending">Menunggu</span>
                                @elseif($request->status == 'approved')
                                    <span class="badge-status badge-approved">Disetujui</span>
                                @else
                                    <span class="badge-status badge-rejected">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-24 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-20">
                                    <span class="text-5xl">🗓️</span>
                                    <p class="text-xs font-bold uppercase tracking-widest">Belum ada riwayat pengajuan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.premium>
