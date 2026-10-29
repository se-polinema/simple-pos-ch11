@extends('layouts.app')

@section('title', 'Ubah Pengguna')

@section('content')
    <x-breadcrumb :items="[['Pengguna', route('users.index')], ['Ubah Pengguna']]" />
    <h1 class="text-lg font-display font-semibold mb-4">Ubah Pengguna</h1>

    <x-card class="max-w-lg">
        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')
            @include('users._form')
            <div class="flex gap-2">
                <x-button type="submit">Perbarui</x-button>
                <x-button variant="ghost" :href="route('users.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
@endsection
