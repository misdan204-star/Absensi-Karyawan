<x-layouts.premium>
    <x-slot:headerTitle>Kelola Data Karyawan</x-slot:headerTitle>

    <div class="p-6 lg:p-10 space-y-8">
        <div class="flex justify-between items-center bg-white/[0.02] p-8 rounded-[32px] border border-white/5">
            <div>
                <h3 class="text-xl font-bold text-white tracking-tight">MANAJEMEN STAFF</h3>
                <p class="text-xs text-indigo-300/50 uppercase font-bold tracking-widest mt-1">Daftar Karyawan Aktif</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 rounded-2xl font-bold shadow-xl shadow-indigo-600/20 active:scale-95 transition text-xs tracking-widest">
                + TAMBAH KARYAWAN
            </a>
        </div>

        <div class="glass overflow-hidden rounded-[32px] border-white/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest">Identitas Staff</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest">NIK & Departemen</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest text-center">Akses Sistem</th>
                            <th class="py-6 px-8 text-[10px] font-bold text-indigo-300/40 uppercase tracking-widest text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="border-b border-white/5 hover:bg-white/[0.01] transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-xl flex items-center justify-center font-bold text-indigo-300 text-sm border border-white/5">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white/90 leading-tight">{{ $user->name }}</div>
                                        <div class="text-[11px] text-white/30 mt-1">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <div class="text-sm font-bold text-white/70">{{ $user->nik }}</div>
                                <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mt-1">{{ $user->department ?? 'N/A' }}</div>
                            </td>
                            <td class="py-6 px-8 text-center">
                                <span class="px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30' : 'bg-slate-500/10 text-slate-400 border border-white/5' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-6 px-8">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 px-4 rounded-xl glass text-[10px] font-extrabold text-amber-400 hover:bg-amber-400 hover:text-black transition uppercase tracking-widest">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 px-4 rounded-xl glass text-[10px] font-extrabold text-rose-500 hover:bg-rose-500 hover:text-white transition uppercase tracking-widest">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-8 bg-black/20 border-t border-white/5">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-layouts.premium>
