<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $todayTransactionCount = Order::whereDate('created_at', today())->count();
        
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');
        
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();

        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(10)
            ->get();

        return view('kasir.dashboard', compact(
            'todayTransactionCount',
            'todayRevenue',
            'pendingOrders',
            'processingOrders',
            'recentOrders'
        ));
    }
}