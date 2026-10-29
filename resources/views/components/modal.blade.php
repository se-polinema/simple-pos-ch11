@props(['id', 'title' => null, 'maxWidth' => 'max-w-sm'])
<div x-show="$store.modal.current === '{{ $id }}'" x-cloak x-transition.opacity
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     @keydown.escape.window="$store.modal.close()">
    <div class="fixed inset-0 bg-black/50" @click="$store.modal.close()"></div>
    <div class="relative bg-surface-raised rounded-lg border border-ink/10 shadow-lg w-full {{ $maxWidth }} p-6" @click.stop>
        @if ($title)
            <h3 class="font-display font-semibold mb-3">{{ $title }}</h3>
        @endif
        {{ $slot }}
    </div>
</div>
