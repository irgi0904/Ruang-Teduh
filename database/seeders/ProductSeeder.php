<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kopiSignature = Category::where('slug', 'kopi-signature')->first();
        $nonCoffee = Category::where('slug', 'non-coffee')->first();
        $makananRingan = Category::where('slug', 'makanan-ringan')->first();
        $minumanDingin = Category::where('slug', 'minuman-dingin')->first();

        $products = [
            [
                'category_id' => $kopiSignature->id,
                'name' => 'Kopi Kenangan Pertama',
                'slug' => 'kopi-kenangan-pertama',
                'description' => 'Espresso dengan sentuhan karamel dan vanilla',
                'story' => 'Setiap tegukan membawa kembali memori manis pertama kali bertemu di kafe ini.',
                'image' => 'img/products/kopi-1.jpg',
                'price' => 25000,
                'stock' => 500,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $kopiSignature->id,
                'name' => 'Cerita Senja',
                'slug' => 'cerita-senja',
                'description' => 'Cappuccino dengan sentuhan madu dan kayu manis',
                'story' => 'Ditemani senja yang perlahan meredup, secangkir cappuccino ini menghadirkan kehangatan.',
                'image' => 'img/products/kopi-2.jpg',
                'price' => 22000,
                'stock' => 500,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $kopiSignature->id,
                'name' => 'Pelukan Hangat',
                'slug' => 'pelukan-hangat',
                'description' => 'Latte dengan cokelat belgia premium',
                'story' => 'Seperti pelukan hangat di pagi yang dingin, latte ini menghadirkan kenyamanan.',
                'image' => 'img/products/kopi-3.jpg',
                'price' => 23000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Teh Rempah Nusantara',
                'slug' => 'teh-rempah-nusantara',
                'description' => 'Teh hitam dengan rempah tradisional',
                'story' => 'Perjalanan rasa melintasi nusantara dalam secangkir teh.',
                'image' => 'img/products/teh.jpg',
                'price' => 20000,
                'stock' => 500,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Susu Cokelat Nostalgia',
                'slug' => 'susu-cokelat-nostalgia',
                'description' => 'Susu cokelat premium dengan marshmallow',
                'story' => 'Membawa kembali kenangan masa kecil yang manis.',
                'image' => 'img/products/cokelat.jpg',
                'price' => 28000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $makananRingan->id,
                'name' => 'Croissant Mentega',
                'slug' => 'croissant-mentega',
                'description' => 'Croissant renyah dengan mentega premium',
                'story' => 'Dipanggang fresh setiap pagi, croissant ini renyah di luar dan lembut di dalam.',
                'image' => 'img/products/croissant.jpg',
                'price' => 22000,
                'stock' => 50,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $makananRingan->id,
                'name' => 'Kue Lapis Legit',
                'slug' => 'kue-lapis-legit',
                'description' => 'Lapis legit tradisional dengan rempah',
                'story' => 'Resep turun temurun yang dijaga dengan penuh cinta.',
                'image' => 'img/products/lapis.jpg',
                'price' => 45000,
                'stock' => 30,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $minumanDingin->id,
                'name' => 'Es Kopi Susu Gula Aren',
                'slug' => 'es-kopi-susu-gula-aren',
                'description' => 'Kopi susu dingin dengan gula aren asli',
                'story' => 'Kesegaran kopi bertemu manisnya gula aren.',
                'image' => 'img/products/es-kopi.jpg',
                'price' => 30000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $minumanDingin->id,
                'name' => 'Matcha Latte Dingin',
                'slug' => 'matcha-latte-dingin',
                'description' => 'Matcha premium dari Jepang dengan susu',
                'story' => 'Hijau menenangkan seperti pepohonan di pagi hari.',
                'image' => 'img/products/Matcha.jpg',
                'price' => 35000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}