<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // --- EXPORT LOGIC ---
        // Jika ada request export, jalankan fungsi download
        if ($request->has('export_type')) {
            return $this->downloadCsv($request->export_type, $startDate, $endDate);
        }

        // --- DATA LOGIC ---
        $totalOrders = Order::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();
        
        $totalRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total');
        
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereDate('created_at', '>=', $startDate)
                      ->whereDate('created_at', '<=', $endDate);
            })
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        $dailyRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $ordersByType = Order::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->select('order_type', DB::raw('COUNT(*) as count'))
            ->groupBy('order_type')
            ->get();

        $paymentMethodsRaw = Order::with('payment')
            ->where('status', 'completed')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        $paymentMethods = $paymentMethodsRaw->groupBy(function ($order) {
                return $order->payment ? $order->payment->payment_method : 'Unknown';
            })
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total' => $group->sum('total')
                ];
            });

        // Pastikan nama view sesuai lokasi file kamu
        return view('reports.index', compact(
            'startDate', 'endDate', 'totalOrders', 'totalRevenue', 
            'averageOrderValue', 'topProducts', 'dailyRevenue', 
            'ordersByType', 'paymentMethods'
        ));
    }

    // --- FUNGSI DOWNLOAD CSV ---
    private function downloadCsv($type, $startDate, $endDate)
    {
        $filename = "laporan_{$type}_{$startDate}_{$endDate}.csv";
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($type, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            if ($type == 'penjualan') {
                // Header CSV Penjualan
                fputcsv($file, ['Tanggal', 'No Order', 'Pelanggan', 'Tipe', 'Total (Rp)', 'Status']);

                // Data Penjualan
                Order::whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->chunk(100, function($orders) use ($file) {
                        foreach ($orders as $order) {
                            fputcsv($file, [
                                $order->created_at->format('Y-m-d H:i'),
                                $order->order_number,
                                $order->customer_name,
                                $order->order_type,
                                $order->total,
                                $order->status
                            ]);
                        }
                    });

            } elseif ($type == 'produk') {
                // Header CSV Produk
                fputcsv($file, ['Nama Produk', 'Jumlah Terjual']);

                // Data Produk
                $products = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
                    ->whereHas('order', function ($query) use ($startDate, $endDate) {
                        $query->where('status', 'completed')
                              ->whereDate('created_at', '>=', $startDate)
                              ->whereDate('created_at', '<=', $endDate);
                    })
                    ->groupBy('product_name')
                    ->orderBy('total_sold', 'desc')
                    ->get();

                foreach ($products as $p) {
                    fputcsv($file, [$p->product_name, $p->total_sold]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function export(Request $request) { return back(); } 
}