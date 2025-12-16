<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Topping;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class ProductRelationSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $toppings = Topping::all();
        $variants = Variant::all();

        foreach ($products as $product) {
            $randomToppings = $toppings->random(rand(3, 6));
            $product->toppings()->attach($randomToppings);

            $sizeVariants = $variants->where('type', 'size');
            $tempVariants = $variants->where('type', 'temperature');
            $sweetVariants = $variants->where('type', 'sweetness');

            $product->variants()->attach($sizeVariants);
            $product->variants()->attach($tempVariants);
            $product->variants()->attach($sweetVariants);
        }
    }
}