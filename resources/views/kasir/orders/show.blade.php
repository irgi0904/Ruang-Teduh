<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-6 flex items-center justify-center h-screen">

    <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gray-800 text-white p-4 flex justify-between items-center">
            <h2 class="text-lg font-bold">Detail Pesanan #ORD-001</h2>
            <a href="{{ route('kasir.index') }}" class="text-sm hover:text-gray-300">
                <i class="fas fa-times"></i> Tutup
            </a>
        </div>

        <div class="p-6">
            <div class="flex justify-between mb-6 border-b pb-4">
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-bold">15 Des 2025, 10:30</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kasir</p>
                    <p class="font-bold">Budi Santoso</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Status</p>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">LUNAS</span>
                </div>
            </div>

            <table class="w-full mb-6">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b">
                        <th class="pb-2">Produk</th>
                        <th class="pb-2 text-center">Qty</th>
                        <th class="pb-2 text-right">Harga</th>
                        <th class="pb-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="border-b">
                        <td class="py-2">Kopi Susu Gula Aren</td>
                        <td class="py-2 text-center">2</td>
                        <td class="py-2 text-right">18.000</td>
                        <td class="py-2 text-right">36.000</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2">Roti Bakar</td>
                        <td class="py-2 text-center">1</td>
                        <td class="py-2 text-right">12.000</td>
                        <td class="py-2 text-right">12.000</td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-1/2">
                    <div class="flex justify-between py-1">
                        <span class="text-gray-600">Total</span>
                        <span class="font-bold text-xl">Rp 48.000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 flex justify-end gap-3">
            <a href="{{ route('kasir.receipt', 1) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
                <i class="fas fa-print mr-2"></i> Cetak Struk
            </a>
        </div>
    </div>

</body>
</html>