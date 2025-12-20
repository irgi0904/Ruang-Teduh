<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        $recentOrders = Order::whereDate('created_at', $today)
            ->with(['kasir'])
            ->latest()
            ->take(10)
            ->get();

        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedToday = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        return view('kasir.dashboard', compact(
            'todayRevenue', 
            'recentOrders', 
            'pendingOrders', 
            'processingOrders', 
            'completedToday'
        ));
    }
}