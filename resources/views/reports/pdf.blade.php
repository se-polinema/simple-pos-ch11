<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 24px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #21201c; }
        h1 { font-size: 16px; margin: 0 0 2px; }
        .muted { color: #57544c; margin: 0 0 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        th, td { padding: 5px 6px; text-align: left; border-bottom: 1px solid #e5e1d8; }
        th { text-transform: uppercase; font-size: 9px; letter-spacing: 0.05em; color: #57544c; border-bottom: 1px solid #21201c; }
        .right { text-align: right; }
        .mono { font-family: 'DejaVu Sans Mono', monospace; }
        .stats td { border: none; padding: 2px 12px 2px 0; }
        .stats .label { color: #57544c; font-size: 9px; text-transform: uppercase; }
        .stats .value { font-size: 15px; font-weight: bold; }
        .section-title { font-size: 12px; font-weight: bold; margin: 0 0 6px; }
    </style>
</head>
<body>
    <h1>{{ $shopSetting->name }} — Laporan Penjualan</h1>
    @if ($shopSetting->address || $shopSetting->phone)
        <p class="muted">{{ collect([$shopSetting->address, $shopSetting->phone])->filter()->implode(' &middot; ') }}</p>
    @endif
    <p class="muted">Periode {{ $from->format('d M Y') }} &ndash; {{ $to->format('d M Y') }}</p>

    <table class="stats">
        <tr>
            <td>
                <div class="label">Total Penjualan</div>
                <div class="value mono">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Jumlah Transaksi</div>
                <div class="value mono">{{ $jumlahTransaksi }}</div>
            </td>
            <td>
                <div class="label">Rata-rata per Transaksi</div>
                <div class="value mono">Rp {{ number_format($avgTransaksi, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <p class="section-title">{{ $granularity === 'day' ? 'Tren Penjualan Harian' : 'Tren Penjualan Bulanan' }}</p>
    <table>
        <thead>
            <tr>
                <th>{{ $granularity === 'day' ? 'Tanggal' : 'Bulan' }}</th>
                <th>Transaksi</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($periodBreakdown as $point)
                <tr>
                    <td>{{ $point['label'] }}</td>
                    <td class="mono">{{ $point['count'] }}</td>
                    <td class="right mono">Rp {{ number_format($point['total'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data pada rentang ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="section-title">Rekap per Kategori</p>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Terjual</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categoryBreakdown as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="mono">{{ $category->qty_terjual }}</td>
                    <td class="right mono">Rp {{ number_format($category->total_penjualan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data pada rentang ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="section-title">Rekap per Kasir</p>
    <table>
        <thead>
            <tr>
                <th>Kasir</th>
                <th>Transaksi</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cashierBreakdown as $cashier)
                <tr>
                    <td>{{ $cashier['name'] }}</td>
                    <td class="mono">{{ $cashier['count'] }}</td>
                    <td class="right mono">Rp {{ number_format($cashier['total'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data pada rentang ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="section-title">Daftar Transaksi</p>
    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td class="mono">{{ $transaction->invoice_no }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td class="right mono">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada transaksi pada rentang ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
