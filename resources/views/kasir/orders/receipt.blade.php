<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
            max-width: 300px;
            margin: 0 auto;
        }
        .receipt {
            border: 2px dashed #000;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            margin: 2px 0;
        }
        .section {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .items {
            margin: 10px 0;
        }
        .item {
            margin-bottom: 8px;
        }
        .item-name {
            font-weight: bold;
        }
        .item-detail {
            font-size: 10px;
            color: #333;
            margin-left: 10px;
        }
        .total-section {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #000;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .grand-total {
            font-size: 16px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #000;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            font-size: 10px;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">

        <div class="header">
            <h1>☕ {{ $settings->cafe_name ?? 'RUANG TEDUH' }}</h1>
            <p>{{ $settings->cafe_address ?? 'Jl. Cerita No. 123, Jakarta' }}</p>
            <p>Telp: {{ $settings->cafe_phone ?? '021-12345678' }}</p>
        </div>

        <div class="section">
            <div class="row">
                <span>No. Pesanan:</span>
                <span><strong>{{ $order->order_number }}</strong></span>
            </div>
            <div class="row">
                <span>Tanggal:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span>Kasir:</span>
                <span>{{ $order->cashier->name ?? '-' }}</span>
            </div>
            @if($order->table_number)
            <div class="row">
                <span>Meja:</span>
                <span>{{ $order->table_number }}</span>
            </div>
            @endif
        </div>

        <div class="section">
            <div class="row">
                <span>Pelanggan:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            @if($order->customer_phone)
            <div class="row">
                <span>Telepon:</span>
                <span>{{ $order->customer_phone }}</span>
            </div>
            @endif
        </div>

        <div class="items">
            @foreach($order->items as $item)
            <div class="item">
                <div class="row item-name">
                    <span>{{ $item->product_name }}</span>
                    <span></span>
                </div>
                <div class="row">
                    <span>  {{ $item->quantity }} x Rp {{ number_format($item->product_price, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($item->product_price * $item->quantity, 0, ',', '.') }}</span>
                </div>
                
                @if($item->toppings && count(json_decode($item->toppings, true)) > 0)
                    @php
                        $toppingIds = json_decode($item->toppings, true);
                        $toppings = \App\Models\Topping::whereIn('id', $toppingIds)->get();
                    @endphp
                    <div class="item-detail">
                        + {{ $toppings->pluck('name')->join(', ') }}
                        (Rp {{ number_format($item->topping_price, 0, ',', '.') }})
                    </div>
                @endif

                @if($item->variants && count(json_decode($item->variants, true)) > 0)
                    @php
                        $variantIds = json_decode($item->variants, true);
                        $variants = \App\Models\Variant::whereIn('id', $variantIds)->get();
                    @endphp
                    <div class="item-detail">
                        {{ $variants->pluck('name')->join(', ') }}
                        @if($item->variant_price > 0)
                            (Rp {{ number_format($item->variant_price, 0, ',', '.') }})
                        @endif
                    </div>
                @endif

                @if($item->notes)
                <div class="item-detail" style="font-style: italic;">
                    Catatan: {{ $item->notes }}
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="total-section">
            <div class="row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Pajak ({{ $settings->tax_percentage ?? 10 }}%):</span>
                <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
            <div class="row">
                <span>Diskon:</span>
                <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->payment)
        <div class="section">
            <div class="row">
                <span>Metode Bayar:</span>
                <span>{{ strtoupper($order->payment->payment_method) }}</span>
            </div>
            <div class="row">
                <span>Jumlah Bayar:</span>
                <span>Rp {{ number_format($order->payment->paid_amount, 0, ',', '.') }}</span>
            </div>
            @if($order->payment->change_amount > 0)
            <div class="row">
                <span>Kembalian:</span>
                <span>Rp {{ number_format($order->payment->change_amount, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>
        @endif

        <div class="footer">
            <p>*** TERIMA KASIH ***</p>
            <p>Selamat menikmati ☕</p>
            <p style="margin-top: 10px;">{{ $settings->cafe_email ?? 'info@ruangteduh.test' }}</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #3B2F2F; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            🖨️ Cetak Struk
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ccc; color: #333; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
            }, 500);
        };
    </script>
</body>
</html> 