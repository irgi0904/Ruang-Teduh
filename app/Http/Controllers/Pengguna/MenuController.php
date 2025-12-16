<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('kategori') && $request->kategori != null) {
            $query->where('category', $request->kategori);
        }

        $products = $query->get();

        return view('pengguna.menu.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('pengguna.menu.show', compact('product'));
    }
}