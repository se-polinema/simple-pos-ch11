@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-display font-semibold">Pengguna</h1>
        <x-button :href="route('users.create')">+ Pengguna Baru</x-button>
    </div>

    <x-card x-data="{ selected: [] }">
        @if ($users->isEmpty())
            <x-empty-state>Belum ada pengguna.</x-empty-state>
        @else
            <div x-show="selected.length > 0" x-cloak
                 class="mb-3 flex items-center justify-between gap-3 rounded-md border border-brass/30 bg-brass-soft/40 px-3 py-2 text-sm">
                <span><span x-text="selected.length"></span> pengguna dipilih</span>
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('users.bulk-status') }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="is_active" value="1">
                        <template x-for="id in selected" :key="id">
                            <input type="hidden" name="ids[]" :value="id">
                        </template>
                        <x-button type="submit" variant="success" size="sm">Aktifkan</x-button>
                    </form>
                    <form method="POST" action="{{ route('users.bulk-status') }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="is_active" value="0">
                        <template x-for="id in selected" :key="id">
                            <input type="hidden" name="ids[]" :value="id">
                        </template>
                        <x-button type="submit" variant="danger" size="sm">Nonaktifkan</x-button>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-ink-soft border-b border-ink/10 text-xs uppercase tracking-wide">
                        <th class="py-2 w-8">
                            <input type="checkbox"
                                   :checked="selected.length === {{ $users->count() }} && {{ $users->count() }} > 0"
                                   @change="selected = $event.target.checked ? {{ \Illuminate\Support\Js::from($users->pluck('id')) }} : []">
                        </th>
                        <th class="py-2 font-medium"><x-sortable-th column="name" label="Nama" :sort="$sort" :direction="$direction" /></th>
                        <th class="py-2 font-medium"><x-sortable-th column="email" label="Email" :sort="$sort" :direction="$direction" /></th>
                        <th class="py-2 font-medium"><x-sortable-th column="role" label="Peran" :sort="$sort" :direction="$direction" /></th>
                        <th class="py-2 font-medium">Status</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php $toggleLabel = $user->is_active ? 'Nonaktifkan' : 'Aktifkan'; @endphp
                        <tr class="border-b border-ink/5 {{ $user->is_active ? '' : 'opacity-50' }}">
                            <td class="py-3">
                                <input type="checkbox" :checked="selected.includes({{ $user->id }})"
                                       @change="$event.target.checked ? selected.push({{ $user->id }}) : selected = selected.filter(id => id !== {{ $user->id }})">
                            </td>
                            <td class="py-3">{{ $user->name }}</td>
                            <td class="py-3 font-mono text-xs">{{ $user->email }}</td>
                            <td class="py-3">
                                @if ($user->role === 'admin')
                                    <x-badge tone="warn">Admin</x-badge>
                                @else
                                    <x-badge tone="neutral">Kasir</x-badge>
                                @endif
                            </td>
                            <td class="py-3">
                                @if ($user->id !== auth()->id())
                                    <x-status-toggle :checked="$user->is_active"
                                                      :label="$user->is_active ? 'Aktif' : 'Nonaktif'"
                                                      @click="$store.modal.open('toggle-user-{{ $user->id }}')" />
                                @else
                                    <x-status-toggle :checked="$user->is_active"
                                                      :label="$user->is_active ? 'Aktif' : 'Nonaktif'"
                                                      :interactive="false" />
                                    <span class="text-xs text-ink-soft/60 ml-1">(Anda)</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <div class="hidden lg:flex items-center justify-end gap-3">
                                    <a href="{{ route('users.edit', $user) }}" class="text-sm text-ink-soft hover:text-brass hover:underline">Ubah</a>
                                </div>
                                <div class="lg:hidden flex justify-end">
                                    <x-row-menu>
                                        <a href="{{ route('users.edit', $user) }}" class="block w-full text-left px-3 py-2 hover:bg-ink/5">Ubah</a>
                                    </x-row-menu>
                                </div>
                            </td>
                        </tr>

                        @if ($user->id !== auth()->id())
                            <x-modal id="toggle-user-{{ $user->id }}" title="{{ $toggleLabel }} Pengguna">
                                <p class="text-sm text-ink-soft mb-4">
                                    Yakin ingin {{ \Illuminate\Support\Str::lower($toggleLabel) }} <strong>{{ $user->name }}</strong>?
                                </p>
                                <form method="POST" action="{{ route('users.toggle', $user) }}" class="flex justify-end gap-2">
                                    @csrf @method('PATCH')
                                    <x-button type="button" variant="ghost" size="sm" @click="$store.modal.close()">Batal</x-button>
                                    <x-button type="submit" variant="{{ $user->is_active ? 'danger' : 'success' }}" size="sm">{{ $toggleLabel }}</x-button>
                                </form>
                            </x-modal>
                        @endif
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="mt-4"><x-pagination :paginator="$users" /></div>
        @endif
    </x-card>
@endsection
