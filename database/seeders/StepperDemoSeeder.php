<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StepperDemoSeeder extends Seeder
{
    public function run(): void
    {
        $induk = Company::create([
            'name' => 'Induk Corp',
            'slug' => Str::slug('Induk Corp'),
            'status' => 'affiliated',
        ]);

        $anak = Company::create([
            'name' => 'Anak Corp',
            'slug' => Str::slug('Anak Corp'),
            'status' => 'unaffiliated',
            'parent_id' => $induk->id,
        ]);

        $cucu = Company::create([
            'name' => 'Cucu Corp',
            'slug' => Str::slug('Cucu Corp'),
            'status' => 'affiliated',
            'parent_id' => $anak->id,
        ]);

        $kategori = Category::create([
            'name' => 'Kategori Demo',
            'slug' => Str::slug('Kategori Demo'),
        ]);

        Product::create([
            'name' => 'Produk Stepper Demo',
            'slug' => Str::slug('Produk Stepper Demo'),
            'description' => 'Produk untuk test stepper silsilah perusahaan.',
            'categories_id' => $kategori->id,
            'company_id' => $cucu->id,
            'status' => 'affiliated',
            'local_product' => true,
            'source' => 'https://example.com',
            'image' => 'product_images/demo.jpg',
        ]);
    }
}
