@props(['label' => 'Aksi'])
<div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
    <button type="button" @click="open = !open" aria-label="{{ $label }}"
            class="p-1.5 rounded-md text-ink-soft hover:bg-ink/5 hover:text-brass">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 6a2 2 0 100-4 2 2 0 000 4zM10 12a2 2 0 100-4 2 2 0 000 4zM10 18a2 2 0 100-4 2 2 0 000 4z" />
        </svg>
    </button>
    <div x-show="open" x-cloak x-transition.opacity @click="open = false"
         class="absolute right-0 z-20 mt-1 w-44 rounded-md border border-ink/10 bg-surface-raised shadow-lg py-1 text-sm">
        {{ $slot }}
    </div>
</div>
