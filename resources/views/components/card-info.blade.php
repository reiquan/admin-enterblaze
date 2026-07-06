@props([
    'label' => '',
    'value' => ''
])

<div class="rounded-2xl border border-white/10 bg-black/40 p-4">
    <p class="text-xs font-bold uppercase tracking-[0.25em] text-zinc-500">
        {{ $label }}
    </p>

    <p class="mt-2 font-black text-white">
        {{ $value }}
    </p>
</div>