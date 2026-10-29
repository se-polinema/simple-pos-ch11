@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <x-breadcrumb :items="[['Pengguna', route('users.index')], ['Tambah Pengguna']]" />
    <h1 class="text-lg font-display font-semibold mb-4">Tambah Pengguna</h1>

    <x-card class="max-w-lg">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf
            @include('users._form')
            <div class="flex gap-2">
                <x-button type="submit">Simpan</x-button>
                <x-button variant="ghost" :href="route('users.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
@endsection
