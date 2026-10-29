<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 12px; }
        body { font-family: 'DejaVu Sans Mono', monospace; font-size: 10px; color: #21201c; }
        h1 { font-size: 13px; text-align: center; margin: 0 0 2px; }
        .muted { color: #57544c; text-align: center; margin: 0 0 8px; }
        .rule { border-top: 1px dashed #57544c; margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .right { text-align: right; }
        .meta td { padding: 1px 0; }
        .total td { font-weight: bold; font-size: 12px; padding-top: 6px; }
        .foot { text-align: center; margin-top: 10px; color: #57544c; }
    </style>
</head>
<body>
    <h1>{{ $shopSetting->name }}</h1>
    @if ($shopSetting->address || $shopSetting->phone)
        <p class="muted">{{ collect([$shopSetting->address, $shopSetting->phone])->filter()->implode(' &middot; ') }}</p>
    @endif
    <p class="muted">Struk Transaksi</p>

    <table class="meta">
        <tr><td>Invoice</td><td class="right">{{ $transaction->invoice_no }}</td></tr>
        <tr><td>Tanggal</td><td class="right">{{ $transaction->created_at->format('d/m/Y H:i') }}</td></tr>
        <tr><td>Kasir</td><td class="right">{{ $transaction->user->name }}</td></tr>
    </table>

    <div class="rule"></div>

    <table>
        @foreach ($transaction->details as $detail)
            <tr>
                <td colspan="2">{{ $detail->product->name }}</td>
            </tr>
            <tr>
                <td>{{ $detail->qty }} x {{ number_format($detail->price, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="rule"></div>

    <table class="meta">
        <tr><td>Subtotal</td><td class="right">Rp {{ number_format($transaction->details->sum('subtotal'), 0, ',', '.') }}</td></tr>
        @if ($transaction->discount > 0)
            <tr><td>Diskon</td><td class="right">&minus; Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td></tr>
        @endif
        @if ($transaction->tax > 0)
            <tr><td>Pajak</td><td class="right">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</td></tr>
        @endif
    </table>

    <table class="total">
        <tr><td>TOTAL</td><td class="right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td></tr>
    </table>

    <table class="meta">
        <tr><td>Bayar</td><td class="right">{{ $transaction->paymentMethodLabel() }}</td></tr>
        @if ($transaction->payment_method === 'tunai')
            <tr><td>Uang Diterima</td><td class="right">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td></tr>
            <tr><td>Kembalian</td><td class="right">Rp {{ number_format($transaction->change_due, 0, ',', '.') }}</td></tr>
        @endif
    </table>

    <p class="foot">Terima kasih atas kunjungan Anda</p>
</body>
</html>
