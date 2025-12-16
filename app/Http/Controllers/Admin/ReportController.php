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

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        
        $totalRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        $dailyRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $ordersByType = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('order_type', DB::raw('COUNT(*) as count'))
            ->groupBy('order_type')
            ->get();

        $paymentMethods = Order::with('payment')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($order) {
                return $order->payment ? $order->payment->payment_method : 'unpaid';
            })
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total' => $group->sum('total')
                ];
            });

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalOrders',
            'totalRevenue',
            'averageOrderValue',
            'topProducts',
            'dailyRevenue',
            'ordersByType',
            'paymentMethods'
        ));
    }

    public function export(Request $request)
    {
        return back()->with('info', 'Fitur export akan segera tersedia');
    }
}