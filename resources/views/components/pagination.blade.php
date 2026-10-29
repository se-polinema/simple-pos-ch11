@props(['paginator'])
@if ($paginator->hasPages())
    @php
        $baseLink = 'inline-flex items-center justify-center min-w-[2rem] h-8 px-2 rounded-md text-sm';
        $edgeLink = "{$baseLink} border border-ink/15 hover:border-brass hover:text-brass";
        $edgeDisabled = "{$baseLink} border border-ink/10 text-ink-soft/40 cursor-not-allowed";
    @endphp
    <nav class="flex items-center justify-center gap-1" aria-label="Navigasi halaman">
        {{-- First --}}
        @if ($paginator->onFirstPage())
            <span class="{{ $edgeDisabled }}" aria-hidden="true">&laquo;&laquo;</span>
        @else
            <a href="{{ $paginator->url(1) }}" class="{{ $edgeLink }}" aria-label="Halaman pertama">&laquo;&laquo;</a>
        @endif

        @foreach ($paginator->linkCollection() as $link)
            @if ($link['url'] === null && $link['label'] === '...')
                <span class="{{ $baseLink }} text-ink-soft/60">&hellip;</span>
            @elseif ($link['active'])
                <span class="{{ $baseLink }} bg-brass text-surface-raised font-medium" aria-current="page">{{ $link['label'] }}</span>
            @elseif ($link['url'] === null)
                <span class="{{ $edgeDisabled }}" aria-hidden="true">{!! $link['label'] !!}</span>
            @else
                <a href="{{ $link['url'] }}" class="{{ $edgeLink }}">{!! $link['label'] !!}</a>
            @endif
        @endforeach

        {{-- Last --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="{{ $edgeLink }}" aria-label="Halaman terakhir">&raquo;&raquo;</a>
        @else
            <span class="{{ $edgeDisabled }}" aria-hidden="true">&raquo;&raquo;</span>
        @endif
    </nav>
@endif
