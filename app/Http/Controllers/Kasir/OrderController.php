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
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['kasir', 'items', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->paginate(15);
        
        return view('kasir.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('is_available', true)->get();
        $categories = Category::where('is_active', true)->get();
        
        return view('kasir.orders.create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'table_number' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,debit',
            'paid_amount' => 'required|numeric|min:0',
            'total' => 'required|numeric',
        ]);

        DB::beginTransaction();
        
        try {
            $settings = CafeSetting::first();
            $taxPercentage = $settings ? $settings->tax_percentage : 0;
            
            $subtotal = $validated['total'];
            $tax = $subtotal * ($taxPercentage / 100);
            $totalFinal = $subtotal + $tax;

            $order = Order::create([
                'order_number' => 'RT-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
                'kasir_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'order_type' => $validated['table_number'] ? 'dine_in' : 'takeaway',
                'table_number' => $validated['table_number'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => 0,
                'total' => $totalFinal,
                'status' => 'completed',
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $totalFinal,
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => max(0, $validated['paid_amount'] - $totalFinal),
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('kasir.orders.index')->with('success', 'Pesanan berhasil dicatat');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load(['kasir', 'items', 'payment']);
        return view('kasir.orders.show', compact('order'));
    }

    public function markAsPaid(Order $order)
    {
        if ($order->status !== 'completed') {
            $order->update(['status' => 'completed']);
            if ($order->payment) {
                $order->payment->update(['status' => 'paid', 'paid_at' => now()]);
            }
            return back()->with('success', 'Pesanan selesai');
        }
        return back()->with('error', 'Pesanan sudah selesai');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Status diperbarui');
    }

    public function receipt(Order $order)
    {
        $order->load(['kasir', 'items', 'payment']);
        $settings = CafeSetting::first();
        return view('kasir.orders.receipt', compact('order', 'settings'));
    }
}