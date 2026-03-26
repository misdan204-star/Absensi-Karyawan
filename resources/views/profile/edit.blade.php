<x-layouts.premium>
    <x-slot:headerTitle>Pengaturan Profil</x-slot:headerTitle>

    <div class="p-6 lg:p-10 max-w-4xl mx-auto space-y-10">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-white tracking-tight">PENGATURAN AKUN</h1>
            <p class="text-indigo-300/50 text-xs font-bold uppercase tracking-widest mt-1">Kelola informasi pribadi & keamanan Anda</p>
        </div>

        <div class="glass p-8 lg:p-12 rounded-[40px] border-white/5 shadow-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="glass p-8 lg:p-12 rounded-[40px] border-white/5 shadow-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="bg-rose-500/5 p-8 lg:p-12 rounded-[40px] border border-rose-500/10 shadow-2xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-layouts.premium>
