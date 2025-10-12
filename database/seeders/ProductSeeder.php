<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sodaCategory = Category::where('name', 'Minuman Soda')->first();
        $mieCategory = Category::where('name', 'Mie Instan')->first();
        $airCategory = Category::where('name', 'Air Mineral')->first();
        $obatCategory = Category::where('name', 'Obat & Alat Kesehatan')->first();

        if (! $sodaCategory) {
            $sodaCategory = Category::firstOrCreate(
                ['slug' => Str::slug('Minuman Soda')],
                ['name' => 'Minuman Soda']
            );
        }
        if (! $mieCategory) {
            $mieCategory = Category::firstOrCreate(
                ['slug' => Str::slug('Mie Instan')],
                ['name' => 'Mie Instan']
            );
        }
        if (! $airCategory) {
            $airCategory = Category::firstOrCreate(
                ['slug' => Str::slug('Air Mineral')],
                ['name' => 'Air Mineral']
            );
        }
        if (! $obatCategory) {
            $obatCategory = Category::firstOrCreate(
                ['slug' => Str::slug('Obat & Alat Kesehatan')],
                ['name' => 'Obat & Alat Kesehatan']
            );
        }

        $cocaColaCompany = Company::firstOrCreate(
            ['slug' => Str::slug('The Coca-Cola Company')],
            ['name' => 'The Coca-Cola Company', 'status' => 'affiliated']
        );
        $indofoodCompany = Company::firstOrCreate(
            ['slug' => Str::slug('Indofood')],
            ['name' => 'Indofood', 'status' => 'unaffiliated']
        );
        $danoneCompany = Company::firstOrCreate(
            ['slug' => Str::slug('Danone')],
            ['name' => 'Danone', 'status' => 'affiliated']
        );
        $sidomunculCompany = Company::firstOrCreate(
            ['slug' => Str::slug('PT Sido Muncul Tbk')],
            ['name' => 'PT Sido Muncul Tbk', 'status' => 'affiliated']
        );
        $dekaCompany = Company::firstOrCreate(
            ['slug' => Str::slug('PT Dua Kelinci')],
            ['name' => 'PT Dua Kelinci', 'status' => 'unaffiliated']
        );

        $products = [
            [
                'name' => 'Coca-Cola',
                'description' => 'Minuman berkarbonasi rasa kola.',
                'categories_id' => $sodaCategory->id,
                'company_id' => $cocaColaCompany->id,
                'status' => 'affiliated',
                'local_product' => false,
                'source' => 'https://www.instagram.com/reel/C4jx-lCBeke/?utm_source=ig_web_copy_link&igsh=azk2YjlubXJ5anBq',
                'image' => 'product_images/Coacola.jpeg',
            ],
            [
                'name' => 'Indomie',
                'description' => 'Mie instan populer dari Indonesia dengan berbagai varian rasa.',
                'categories_id' => $mieCategory->id,
                'company_id' => $indofoodCompany->id,
                'status' => 'affiliated',
                'local_product' => true,
                'source' => 'https://www.instagram.com/p/CzToTc9LlH-/?utm_source=ig_web_copy_link',
                'image' => 'product_images/Indomie.webp',
            ],
            [
                'name' => 'Aqua',
                'description' => 'Aqua adalah merek air minum dalam kemasan (AMDK) yang diproduksi oleh PT. Aqua Golden Mississippi, yang merupakan bagian dari Grup Danone.',
                'categories_id' => $airCategory->id,
                'company_id' => $danoneCompany->id,
                'status' => 'affiliated',
                'local_product' => true,
                'source' => 'https://www.instagram.com/p/C2zofAHyOhj/?utm_source=ig_web_copy_link&igsh=MW52d2g0Nno4MmI3eA==',
                'image' => 'product_images/aqua.png',
            ],
            [
                'name' => 'Tolak Angin',
                'description' => 'Tolak Angin adalah produk herbal yang diproduksi oleh PT Sido Muncul Tbk, dikenal sebagai suplemen kesehatan tradisional Indonesia.',
                'categories_id' => $obatCategory->id,
                'company_id' => $sidomunculCompany->id,
                'status' => 'affiliated',
                'local_product' => true,
                'source' => 'https://www.instagram.com/p/CzToTc9LlH-/?utm_source=ig_web_copy_link',
                'image' => 'product_images/tolak_angin.png',
            ],
            [
                'name' => 'Deka Wafer Roll',
                'description' => 'Deka Wafer Roll adalah produk wafer gulung yang diproduksi oleh PT Dua Kelinci, dikenal dengan rasa yang lezat dan renyah.',
                'categories_id' => $obatCategory->id,
                'company_id' => $dekaCompany->id,
                'status' => 'unaffiliated',
                'local_product' => true,
                'source' => 'https://www.instagram.com/p/DAxI2TKPeJN/?utm_source=ig_web_copy_link&igsh=NmR2dnduaGs1MnV2',
                'image' => 'product_images/deka.png',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'categories_id' => $product['categories_id'],
                    'company_id' => $product['company_id'],
                    'status' => $product['status'],
                    'local_product' => $product['local_product'],
                    'source' => $product['source'],
                    'image' => $product['image'],
                ]
            );
        }
    }
}
