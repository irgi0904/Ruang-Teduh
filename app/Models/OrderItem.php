<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'toppings',
        'variants',
        'topping_price',
        'variant_price',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'topping_price' => 'decimal:2',
        'variant_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'toppings' => 'array',
        'variants' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}