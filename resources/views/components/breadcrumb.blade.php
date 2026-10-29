@props(['items'])
<nav class="flex items-center gap-1.5 text-xs text-ink-soft mb-3" aria-label="Breadcrumb">
    @foreach ($items as $item)
        @if (!$loop->first)
            <span class="text-ink-soft/40">/</span>
        @endif
        @if (!$loop->last && ($item[1] ?? null))
            <a href="{{ $item[1] }}" class="hover:text-brass hover:underline">{{ $item[0] }}</a>
        @else
            <span class="text-ink">{{ $item[0] }}</span>
        @endif
    @endforeach
</nav>
