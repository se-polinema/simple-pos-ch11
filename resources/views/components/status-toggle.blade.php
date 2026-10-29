@props(['checked' => false, 'label' => null, 'interactive' => true])
@php
    $track = $checked ? 'bg-signal-green' : 'bg-ink/20';
    $thumb = $checked ? 'translate-x-4' : 'translate-x-0.5';
    $labelColor = $checked ? 'text-signal-green' : 'text-ink-soft';
@endphp
@if ($interactive)
    <button type="button" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 cursor-pointer']) }}>
        <span class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full transition-colors {{ $track }}">
            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $thumb }}"></span>
        </span>
        <span class="text-xs font-medium font-mono {{ $labelColor }}">{{ $label }}</span>
    </button>
@else
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 opacity-70']) }}>
        <span class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full {{ $track }}">
            <span class="inline-block h-4 w-4 rounded-full bg-white shadow {{ $thumb }}"></span>
        </span>
        <span class="text-xs font-medium font-mono {{ $labelColor }}">{{ $label }}</span>
    </span>
@endif
