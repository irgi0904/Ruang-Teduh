<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\CafeSetting;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'kasir', 'items', 'payment']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->paginate(20);
        
        return view('kasir.orders.index', compact('orders'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->with('products')->get();
        $products = Product::where('is_available', true)->with(['toppings', 'variants'])->get();
        
        return view('kasir.orders.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'table_number' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.toppings' => 'nullable|array',
            'items.*.variants' => 'nullable|array',
            'items.*.notes' => 'nullable|string',
            'payment_method' => 'required|in:cash,qris,debit,credit',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            $settings = CafeSetting::getSettings();
            $subtotal = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $productPrice = $product->price;
                
                $toppingPrice = 0;
                if (!empty($item['toppings'])) {
                    $toppingPrice = DB::table('toppings')
                        ->whereIn('id', $item['toppings'])
                        ->sum('price');
                }
                
                $variantPrice = 0;
                if (!empty($item['variants'])) {
                    $variantPrice = DB::table('variants')
                        ->whereIn('id', $item['variants'])
                        ->sum('price_adjustment');
                }
                
                $itemSubtotal = ($productPrice + $toppingPrice + $variantPrice) * $item['quantity'];
                $subtotal += $itemSubtotal;
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $productPrice,
                    'quantity' => $item['quantity'],
                    'toppings' => !empty($item['toppings']) ? json_encode($item['toppings']) : null,
                    'variants' => !empty($item['variants']) ? json_encode($item['variants']) : null,
                    'topping_price' => $toppingPrice,
                    'variant_price' => $variantPrice,
                    'subtotal' => $itemSubtotal,
                    'notes' => $item['notes'] ?? null,
                ];
            }

            $tax = $subtotal * ($settings->tax_percentage / 100);
            $total = $subtotal + $tax;

            $order = Order::create([
                'user_id' => null,
                'kasir_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'table_number' => $validated['table_number'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => 0,
                'total' => $total,
                'status' => 'completed',
                'notes' => $validated['notes'],
            ]);

            foreach ($orderItems as $orderItem) {
                $order->items()->create($orderItem);
            }

            $changeAmount = $validated['paid_amount'] - $total;

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $total,
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => max(0, $changeAmount),
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('kasir.orders.receipt', $order)
                ->with('success', 'Pesanan berhasil dibuat');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load(['user', 'kasir', 'items', 'payment']);
        $settings = CafeSetting::getSettings();
        
        return view('kasir.orders.show', compact('order', 'settings'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function approvePayment(Order $order)
    {
        if (!$order->payment) {
            return back()->with('error', 'Pembayaran tidak ditemukan');
        }

        if ($order->payment->status === 'paid') {
            return back()->with('info', 'Pembayaran sudah disetujui');
        }

        $order->payment()->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Pembayaran berhasil disetujui');
    }

    public function receipt(Order $order)
    {
        $order->load(['kasir', 'items', 'payment']);
        $settings = CafeSetting::getSettings();
        
        return view('kasir.orders.receipt', compact('order', 'settings'));
    }
}