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
        $sodaCategory = Category::where('name', 'Minuman Soda')->first();
        $mieCategory = Category::where('name', 'Mie Instan')->first();

        if (!$sodaCategory) {
            $sodaCategory = Category::firstOrCreate(
                ['slug' => Str::slug('Minuman Soda')],
                ['name' => 'Minuman Soda']
            );
        }
        if (!$mieCategory) {
            $mieCategory = Category::firstOrCreate(
                ['slug' => Str::slug('Mie Instan')],
                ['name' => 'Mie Instan']
            );
        }

        $cocaColaCompany = Company::firstOrCreate(
            ['slug' => Str::slug('The Coca-Cola Company')],
            ['name' => 'The Coca-Cola Company', 'status' => 'Affiliated']
        );
        $indofoodCompany = Company::firstOrCreate(
            ['slug' => Str::slug('Indofood')],
            ['name' => 'Indofood', 'status' => 'Unaffiliated']
        );

        $products = [
            [
                'name' => 'Coca-Cola',
                'description' => 'Minuman berkarbonasi rasa kola.',
                'categories_id' => $sodaCategory->id,
                'company_id' => $cocaColaCompany->id,
                'status' => 'Affiliated',
                'local_product' => false,
                'source' => 'https://www.coca-cola.com/',
                'image' => 'product_images/Coacola.jpeg'
            ],
            [
                'name' => 'Indomie',
                'description' => 'Mie instan populer dari Indonesia dengan berbagai varian rasa.',
                'categories_id' => $mieCategory->id,
                'company_id' => $indofoodCompany->id,
                'status' => 'Affiliated',
                'local_product' => true,
                'source' => 'https://www.indomie.com/',
                'image' => 'product_images/Indomie.webp'
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