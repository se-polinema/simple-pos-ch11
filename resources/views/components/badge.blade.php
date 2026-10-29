@props(['tone' => 'neutral'])
@php
    $tones = [
        'neutral' => 'bg-ink/5 text-ink-soft',
        'warn' => 'bg-brass-soft text-brass',
        'danger' => 'bg-signal-red-soft text-signal-red',
        'success' => 'bg-signal-green-soft text-signal-green',
    ];
@endphp
<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium font-mono ' . ($tones[$tone] ?? $tones['neutral'])]) }}>{{ $slot }}</span>
