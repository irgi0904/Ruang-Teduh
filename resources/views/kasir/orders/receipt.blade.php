<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            max-width: 300px; 
            margin: 0 auto;
            padding: 10px;
            background: white;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 5px 0; }
        .flex { display: flex; justify-content: space-between; }
        
        @media print {
            body { margin: 0; padding: 0; }
            button { display: none; } 
        }
    </style>
</head>
<body onload="window.print()"> <div class="text-center">
        <h2 style="margin-bottom: 0;">MY COFFEE SHOP</h2>
        <p>Jl. Mawar No. 123, Jakarta</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <div class="line"></div>

    <div class="flex">
        <span>No: #ORD-001</span>
        <span>15/12/2025</span>
    </div>
    <div class="flex">
        <span>Kasir: Budi</span>
        <span>10:30</span>
    </div>

    <div class="line"></div>

    <div style="margin-bottom: 5px;">
        <div>Kopi Susu Gula Aren</div>
        <div class="flex">
            <span>2 x 18.000</span>
            <span>36.000</span>
        </div>
    </div>

    <div style="margin-bottom: 5px;">
        <div>Roti Bakar</div>
        <div class="flex">
            <span>1 x 12.000</span>
            <span>12.000</span>
        </div>
    </div>

    <div class="line"></div>

    <div class="flex bold">
        <span>TOTAL</span>
        <span>Rp 48.000</span>
    </div>
    <div class="flex">
        <span>Bayar</span>
        <span>Rp 50.000</span>
    </div>
    <div class="flex">
        <span>Kembali</span>
        <span>Rp 2.000</span>
    </div>

    <div class="line"></div>

    <div class="text-center" style="margin-top: 10px;">
        <p>Terima Kasih</p>
        <p>Silahkan Datang Kembali</p>
    </div>

    <button onclick="window.print()" style="margin-top: 20px; width: 100%; padding: 10px; cursor: pointer;">Print Struk</button>

</body>
</html>