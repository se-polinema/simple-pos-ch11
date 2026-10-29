@extends('layouts.app')

@section('title', 'Pengaturan Toko')

@section('content')
    <h1 class="text-lg font-display font-semibold mb-4">Pengaturan Toko</h1>

    <x-card class="max-w-lg">
        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">Nama Toko</label>
                <input type="text" name="name" value="{{ old('name', $setting->name) }}" required
                       class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
                <p class="text-xs text-ink-soft mt-1">Tampil di halaman login, sidebar, dan struk/laporan PDF.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Alamat</label>
                <input type="text" name="address" value="{{ old('address', $setting->address) }}"
                       class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}"
                       class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Logo</label>
                @if ($setting->logo_url)
                    <img src="{{ $setting->logo_url }}" alt="Logo toko" class="w-16 h-16 object-cover rounded-md border border-ink/10 mb-2">
                @endif
                <input type="file" name="logo" accept="image/*"
                       class="block w-full text-sm text-ink-soft file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border file:border-ink/15 file:bg-surface-raised file:text-sm file:font-medium hover:file:border-brass">
                <p class="text-xs text-ink-soft mt-1">Opsional, maks 2MB. Kosongkan untuk mempertahankan logo saat ini.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Pajak (%)</label>
                <input type="number" name="tax_percent" value="{{ old('tax_percent', $setting->tax_percent) }}" required min="0" max="100"
                       class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm font-mono focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
                <p class="text-xs text-ink-soft mt-1">Diterapkan otomatis ke setiap transaksi kasir (0 = tanpa pajak).</p>
            </div>
            <div class="flex gap-2">
                <x-button type="submit">Simpan</x-button>
                <x-button variant="ghost" :href="route('dashboard')">Batal</x-button>
            </div>
        </form>
    </x-card>
@endsection
