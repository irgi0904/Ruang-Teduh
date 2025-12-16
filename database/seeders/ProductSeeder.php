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
                'story' => 'Setiap tegukan membawa kembali memori manis pertama kali bertemu di kafe ini. Aroma karamel berpadu dengan vanilla, seperti kenangan yang tak pernah pudar.',
                'price' => 32000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $kopiSignature->id,
                'name' => 'Cerita Senja',
                'slug' => 'cerita-senja',
                'description' => 'Cappuccino dengan sentuhan madu dan kayu manis',
                'story' => 'Ditemani senja yang perlahan meredup, secangkir cappuccino ini menghadirkan kehangatan. Madu dan kayu manis berpadu sempurna, seperti cerita yang terukir di langit sore.',
                'price' => 35000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $kopiSignature->id,
                'name' => 'Pelukan Hangat',
                'slug' => 'pelukan-hangat',
                'description' => 'Latte dengan cokelat belgia premium',
                'story' => 'Seperti pelukan hangat di pagi yang dingin, latte ini menghadirkan kenyamanan. Cokelat Belgia premium meleleh sempurna, memberikan rasa yang memanjakan.',
                'price' => 38000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Teh Rempah Nusantara',
                'slug' => 'teh-rempah-nusantara',
                'description' => 'Teh hitam dengan rempah tradisional',
                'story' => 'Perjalanan rasa melintasi nusantara dalam secangkir teh. Jahe, kayu manis, dan cengkeh berpadu menciptakan kehangatan yang menenangkan.',
                'price' => 25000,
                'stock' => 100,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Susu Cokelat Nostalgia',
                'slug' => 'susu-cokelat-nostalgia',
                'description' => 'Susu cokelat premium dengan marshmallow',
                'story' => 'Membawa kembali kenangan masa kecil yang manis. Susu cokelat hangat dengan marshmallow yang lembut, seperti dekapan ibu di malam yang dingin.',
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
                'story' => 'Dipanggang fresh setiap pagi, croissant ini renyah di luar dan lembut di dalam. Aroma mentega yang harum mengisi ruangan, mengundang untuk segera dinikmati.',
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
                'story' => 'Resep turun temurun yang dijaga dengan penuh cinta. Setiap lapis menyimpan cerita, setiap gigitan adalah perjalanan ke masa lalu yang penuh kehangatan.',
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
                'story' => 'Kesegaran kopi bertemu manisnya gula aren. Seperti kesejukan di tengah teriknya siang, minuman ini memberikan energi dan semangat baru.',
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
                'story' => 'Hijau menenangkan seperti pepohonan di pagi hari. Matcha premium berpadu dengan susu, menciptakan keseimbangan rasa yang sempurna.',
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