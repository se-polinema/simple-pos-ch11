@props(['variant' => 'primary', 'size' => 'md', 'href' => null])
@php
    $variants = [
        'primary' => 'bg-brass text-surface-raised hover:bg-brass/90 focus-visible:outline-brass',
        'dark' => 'bg-rail text-surface-raised hover:bg-rail-soft focus-visible:outline-rail',
        'ghost' => 'bg-transparent text-ink border border-ink/15 hover:bg-ink/5 focus-visible:outline-ink/40',
        'danger' => 'bg-transparent text-signal-red hover:bg-signal-red-soft focus-visible:outline-signal-red',
        'success' => 'bg-signal-green text-surface-raised hover:bg-signal-green/90 focus-visible:outline-signal-green',
    ];
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
    ];
    $classes = 'inline-flex items-center justify-center gap-1.5 rounded-md font-medium transition-colors '
        . 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 '
        . 'disabled:opacity-40 disabled:cursor-not-allowed '
        . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>{{ $slot }}</button>
@endif
