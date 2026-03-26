@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-[10px] uppercase tracking-widest text-indigo-300/40 mb-2 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
