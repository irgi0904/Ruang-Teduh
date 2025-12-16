<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_available', true)
            ->with('category')
            ->take(6)
            ->get();
        
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();
        
        $latestProducts = Product::where('is_available', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('pengguna.home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}