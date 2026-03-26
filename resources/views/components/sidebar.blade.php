@props(['active' => null])

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-[120] sidebar shadow-2xl transition-transform duration-300 md:translate-x-0"
       style="width: 280px; background: rgba(10, 10, 15, 0.8); backdrop-filter: blur(40px); border-right: 1px solid rgba(255, 255, 255, 0.05); display: flex; flex-direction: column;">
    
    <div class="p-8 flex flex-col h-full overflow-hidden">
        <!-- Logo Header -->
        <div class="flex items-center gap-3 mb-10 shrink-0">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-indigo-500/20">✨</div>
            <div>
                <h1 class="font-bold text-lg tracking-tight text-white leading-tight">V-ABSENSI</h1>
                <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">Premium Edition</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto pr-2 custom-scrollbar">
            <!-- Common Menus -->
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4 mb-3 mt-2">Personal</p>
            
            <a href="{{ route('absensi') }}" 
               class="sidebar-item {{ request()->routeIs('absensi') ? 'active' : '' }}">
                <span class="icon">📅</span>
                <span>Absensi Saya</span>
            </a>
            
            <a href="{{ route('leave.create') }}" 
               class="sidebar-item {{ request()->routeIs('leave.create') ? 'active' : '' }}">
                <span class="icon">✚</span>
                <span>Izin / Cuti</span>
            </a>
            
            <a href="{{ route('leave.index') }}" 
               class="sidebar-item {{ request()->routeIs('leave.index') ? 'active' : '' }}">
                <span class="icon">📂</span>
                <span>Riwayat</span>
            </a>

            <!-- Admin Menus -->
            @if(auth()->user()->isAdmin())
                <div class="pt-6">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4 mb-3">Administrator</p>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="icon">👥</span>
                        <span>Data Karyawan</span>
                    </a>
                    
                    <a href="{{ route('admin.leave.index') }}" 
                       class="sidebar-item {{ request()->routeIs('admin.leave.*') ? 'active' : '' }}">
                        <span class="icon">📋</span>
                        <span>Verifikasi Izin</span>
                    </a>
                    
                    <a href="{{ route('admin.export') }}" 
                       class="sidebar-item {{ request()->routeIs('admin.export') ? 'active' : '' }}">
                        <span class="icon">📥</span>
                        <span>Laporan Export</span>
                    </a>
                </div>
            @endif
        </nav>

        <!-- Profile Footer -->
        <div class="pt-6 border-t border-white/5 mt-auto shrink-0">
            <div class="flex items-center gap-3 p-3 glass rounded-2xl mb-4 bg-white/[0.03] ring-1 ring-white/10">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-10 h-10 rounded-xl object-cover border border-white/10 shadow-lg">
                @else
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/20 to-purple-600/20 rounded-xl flex items-center justify-center text-sm border border-white/5">👤</div>
                @endif
                <div class="overflow-hidden">
                    <p class="text-[11px] font-bold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[9px] text-indigo-400 font-bold uppercase tracking-tight">{{ auth()->user()->role }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 p-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-bold hover:bg-rose-500/20 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    LOGOUT SYSTEM
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    .sidebar-item {
        padding: 0.85rem 1.25rem;
        border-radius: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13.5px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.45);
        border: 1px solid transparent;
    }
    .sidebar-item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
    }
    .sidebar-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(168, 85, 247, 0.15));
        color: white;
        border: 1px solid rgba(99, 102, 241, 0.2);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    .sidebar-item .icon { font-size: 1.1rem; }
    
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); border-radius: 20px; }
</style>
