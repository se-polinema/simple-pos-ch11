@extends('layouts.app')

@section('title', 'Pencarian')

@section('content')
    <h1 class="text-lg font-display font-semibold mb-4">
        Hasil Pencarian @if ($q !== '') untuk "{{ $q }}" @endif
    </h1>

    @if ($q === '')
        <x-empty-state>Ketik kata kunci untuk mencari produk, transaksi, atau pengguna.</x-empty-state>
    @elseif ($products->isEmpty() && $transactions->isEmpty() && $users->isEmpty())
        <x-empty-state>
            Tidak ada hasil untuk "{{ $q }}". Periksa ejaan atau coba kata kunci lain.
        </x-empty-state>
    @else
        <div class="space-y-6">
            @if ($products->isNotEmpty())
                <x-card>
                    <h2 class="font-display text-xs font-semibold uppercase tracking-wide text-ink-soft mb-3">
                        Produk ({{ $productsTotal }})
                    </h2>
                    <ul class="divide-y divide-ink/5 text-sm">
                        @foreach ($products as $product)
                            <li class="py-2 flex items-center justify-between gap-3">
                                <span>
                                    <x-highlight :text="$product->name" :query="$q" />
                                    <span class="font-mono text-ink-soft text-xs">{{ $product->sku }}</span>
                                </span>
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('products.edit', $product) }}" class="text-brass hover:underline shrink-0">Ubah</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @if ($productsTotal > $products->count())
                        <p class="text-xs text-ink-soft mt-3">
                            Menampilkan {{ $products->count() }} dari {{ $productsTotal }} — persempit kata kunci untuk hasil lebih spesifik.
                        </p>
                    @endif
                </x-card>
            @endif

            @if ($transactions->isNotEmpty())
                <x-card>
                    <h2 class="font-display text-xs font-semibold uppercase tracking-wide text-ink-soft mb-3">
                        Transaksi ({{ $transactionsTotal }})
                    </h2>
                    <ul class="divide-y divide-ink/5 text-sm">
                        @foreach ($transactions as $transaction)
                            <li class="py-2 flex items-center justify-between gap-3">
                                <span class="font-mono text-xs"><x-highlight :text="$transaction->invoice_no" :query="$q" /></span>
                                <a href="{{ route('transactions.show', $transaction) }}" class="text-brass hover:underline shrink-0">Lihat</a>
                            </li>
                        @endforeach
                    </ul>
                    @if ($transactionsTotal > $transactions->count())
                        <p class="text-xs text-ink-soft mt-3">
                            Menampilkan {{ $transactions->count() }} dari {{ $transactionsTotal }} — persempit kata kunci untuk hasil lebih spesifik.
                        </p>
                    @endif
                </x-card>
            @endif

            @if ($users->isNotEmpty())
                <x-card>
                    <h2 class="font-display text-xs font-semibold uppercase tracking-wide text-ink-soft mb-3">
                        Pengguna ({{ $usersTotal }})
                    </h2>
                    <ul class="divide-y divide-ink/5 text-sm">
                        @foreach ($users as $searchedUser)
                            <li class="py-2 flex items-center justify-between gap-3">
                                <span>
                                    <x-highlight :text="$searchedUser->name" :query="$q" />
                                    <span class="text-ink-soft text-xs">{{ $searchedUser->email }}</span>
                                </span>
                                <a href="{{ route('users.edit', $searchedUser) }}" class="text-brass hover:underline shrink-0">Ubah</a>
                            </li>
                        @endforeach
                    </ul>
                    @if ($usersTotal > $users->count())
                        <p class="text-xs text-ink-soft mt-3">
                            Menampilkan {{ $users->count() }} dari {{ $usersTotal }} — persempit kata kunci untuk hasil lebih spesifik.
                        </p>
                    @endif
                </x-card>
            @endif
        </div>
    @endif
@endsection
