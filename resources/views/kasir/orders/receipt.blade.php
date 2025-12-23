<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->order_number }}</title>
    <style>
        /* CSS KHUSUS STRUK THERMAL (80mm / 58mm) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.2;
            padding: 10px;
            max-width: 300px;
            margin: 0 auto;
            background: #fff;
            color: #000;
        }
        .receipt { width: 100%; }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 { font-size: 18px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
        .header p { font-size: 10px; margin: 2px 0; }
        
        .section { margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px dashed #000; }
        .row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        
        .items { margin: 10px 0; }
        .item { margin-bottom: 10px; border-bottom: 1px dotted #ccc; padding-bottom: 5px; }
        .item-header { display: flex; justify-content: space-between; font-weight: bold; }
        .item-detail { font-size: 10px; color: #444; margin-left: 10px; }
        
        .total-section { margin-top: 5px; padding-top: 5px; border-top: 2px solid #000; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .grand-total { font-size: 16px; font-weight: bold; margin-top: 5px; border-top: 1px dashed #000; padding-top: 5px; }
        
        .footer { text-align: center; margin-top: 15px; padding-top: 10px; border-top: 1px dashed #000; font-size: 10px; }
        
        .no-print { margin-top: 20px; text-align: center; border-top: 1px solid #ccc; padding-top: 10px; }
        .btn { padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold; border: none; }
        .btn-print { background: #000; color: #fff; }
        .btn-close { background: #ddd; color: #000; margin-left: 5px; }

        @media print {
            body { padding: 0; margin: 0; }
            .no-print { display: none; }
            .receipt { border: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="receipt">

        <div class="header">
            <h1>{{ $settings->cafe_name ?? 'RUANG TEDUH' }}</h1>
            
            <p>Jl. Abdullah Lubis No.65, Medan</p>
            <p>+62 878-2463-0419</p>
        </div>

        <div class="section">
            <div class="row">
                <span>No. Pesanan:</span>
                <span style="font-weight: bold;">#{{ $order->order_number }}</span>
            </div>
            <div class="row">
                <span>Waktu:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span>Kasir:</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="row">
                <span>Pelanggan:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            @if($order->table_number)
            <div class="row">
                <span>Meja:</span>
                <span>{{ $order->table_number }}</span>
            </div>
            @endif
        </div>

        <div class="items">
            @foreach($order->items as $item)
            <div class="item">
                <div class="item-header">
                    <span>{{ $item->product_name }}</span>
                    <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                <div style="font-size: 11px;">
                    {{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}
                </div>
                
                @if($item->notes)
                <div class="item-detail">"{{ $item->notes }}"</div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->subtotal ?? $order->total, 0, ',', '.') }}</span>
            </div>
            @if($order->tax > 0)
            <div class="total-row">
                <span>Pajak:</span>
                <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->payment)
        <div class="section" style="border-bottom: none; margin-top: 5px;">
            <div class="row">
                <span>Bayar ({{ strtoupper($order->payment->payment_method) }}):</span>
                <span>Rp {{ number_format($order->payment->paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Kembali:</span>
                <span>Rp {{ number_format($order->payment->change_amount, 0, ',', '.') }}</span>
            </div>
        </div>
        @endif

        <div class="footer">
            <p>*** TERIMA KASIH ***</p>
            <p>Gelap itu menenangkan.</p>
            <p>Late Night Sanctuary</p>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak</button>
        <button onclick="window.close()" class="btn btn-close">Tutup</button>
    </div>

</body>
</html>