<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        return view('pengguna.cart.index', compact('cart', 'subtotal'));
    }

    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'note' => 'nullable|string|max:255'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if (!$product->is_available) { 
            return back()->with('error', 'Maaf, produk ini sedang habis.');
        }

        $cart = session()->get('cart', []);
        $qty = $request->quantity ?? 1;

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
            
            if($request->note) {
                $cart[$product->id]['note'] = $request->note;
            }
        } else {
            $cart[$product->id] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $qty,
                "price" => $product->price,
                "image" => $product->image,
                "note" => $request->note ?? null
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil masuk keranjang!');
    }

    
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }

    
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pengguna.menu.index')
                ->with('error', 'Keranjang kamu kosong, tidak bisa checkout.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        $cartTotal = [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ];

        return view('pengguna.cart.checkout', compact('cart', 'cartTotal'));
    }

    
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->route('pengguna.menu.index')->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'payment_method' => 'required|in:cash,qris',
            'table_number' => 'required|string|max:10',
        ]);

        DB::beginTransaction();
        try {
            
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => auth()->user()->name,
                'order_type' => 'dine_in',
                'table_number' => $request->table_number,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => 0,
                'total' => $total,
                'status' => 'pending', 
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'notes' => $request->notes ?? 'Pesanan via Web',
            ]);

            
            foreach ($cart as $id => $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'notes' => $item['note'] ?? null,
                ]);
            }

            
            session()->forget('cart');
            DB::commit();

            
            return redirect()->route('pengguna.orders.index')->with('success', 'Pesanan berhasil dibuat! Mohon tunggu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}