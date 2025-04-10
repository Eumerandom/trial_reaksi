<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get categories
        $kopiCategory = Category::where('name', 'Kopi')->first();
        $mieCategory = Category::where('name', 'Mie Instan')->first();
        
        // Get Wings Food company
        $wingsFood = Company::where('name', 'Wings Food')->first();

        $products = [
            [
                'name' => 'Kopi Kapal Api',
                'description' => 'Kopi hitam premium asli Indonesia dengan cita rasa khas yang telah menjadi favorit keluarga Indonesia sejak 1927',
                'categories_id' => $kopiCategory->id,
                'company_id' => $wingsFood->id,
                'status' => 'Unaffiliated',
                'local_product' => true,
                'source' => 'https://www.kapalapi.co.id/',
                'image' => 'product_image/kopi-kapal-api.jpg'
            ],
            [
                'name' => 'Kopi ABC',
                'description' => 'Kopi instant dengan rasa yang kuat dan aroma yang khas, diproduksi dengan biji kopi pilihan dari Indonesia',
                'categories_id' => $kopiCategory->id,
                'company_id' => $wingsFood->id,
                'status' => 'Affiliated',
                'local_product' => true,
                'source' => 'https://www.abcpresident.co.id/',
                'image' => 'product_image/kopi-abc.jpg'
            ],
            [
                'name' => 'Mie Sedaap',
                'description' => 'Mie instan dengan berbagai varian rasa khas Indonesia, diproduksi oleh Wings Food',
                'categories_id' => $mieCategory->id,
                'company_id' => $wingsFood->id,
                'status' => 'Affiliated',
                'local_product' => true,
                'source' => 'https://www.wingscorp.com/',
                'image' => 'product_image/mie-sedaap.jpg'
            ],
            [
                'name' => 'Good Day',
                'description' => 'Kopi instant dengan beragam varian rasa modern, cocok untuk generasi muda Indonesia',
                'categories_id' => $kopiCategory->id,
                'company_id' => $wingsFood->id,
                'status' => 'Affiliated',
                'local_product' => true,
                'source' => 'https://www.goodday.co.id/',
                'image' => 'product_image/good-day.jpg'
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'categories_id' => $product['categories_id'],
                'company_id' => $product['company_id'],
                'status' => $product['status'],
                'local_product' => $product['local_product'],
                'source' => $product['source'],
                'image' => $product['image'],
            ]);
        }
    }
}
