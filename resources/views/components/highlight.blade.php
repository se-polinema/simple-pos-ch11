@props(['text', 'query'])
@php
    $escapedText = e($text);
    $result = $query !== ''
        ? preg_replace('/(' . preg_quote(e($query), '/') . ')/i', '<mark class="bg-brass-soft text-ink rounded px-0.5">$1</mark>', $escapedText)
        : $escapedText;
@endphp
{!! $result !!}
