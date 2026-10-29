@props(['column', 'label', 'sort', 'direction'])
@php
    $active = $sort === $column;
    $nextDirection = $active && $direction === 'asc' ? 'desc' : 'asc';
    $url = request()->fullUrlWithQuery(['sort' => $column, 'direction' => $nextDirection, 'page' => null]);
@endphp
<a href="{{ $url }}" class="inline-flex items-center gap-1 hover:text-brass">
    {{ $label }}
    @if ($active)
        <span class="text-[10px]">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
    @endif
</a>
