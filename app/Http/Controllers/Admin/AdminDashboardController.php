<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');
        
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        try {
            $topProducts = Product::withCount('orderItems')
                ->orderBy('order_items_count', 'desc')->take(5)->get();
        } catch (\Exception $e) {
            $topProducts = [];
        }

        return view('admin.dashboard', compact(
            'totalProducts', 'totalCategories', 'totalUsers', 'totalOrders',
            'totalRevenue', 'todayRevenue', 'recentOrders', 'topProducts'
        ));
    }

    public function products()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories', compact('categories'));
    }
}