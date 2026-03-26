@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'glass bg-white/5 border-white/10 text-white placeholder-white/20 focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 rounded-2xl p-4 transition duration-300 outline-none']) }}>
