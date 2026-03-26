<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-violet-600 border border-transparent rounded-2xl font-bold text-xs text-white uppercase tracking-[0.2em] shadow-lg shadow-indigo-600/20 hover:from-indigo-500 hover:to-violet-500 focus:outline-none transition active:scale-95 duration-150']) }}>
    {{ $slot }}
</button>
