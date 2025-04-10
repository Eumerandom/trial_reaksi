<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create main categories
        $minuman = Category::create([
            'name' => 'Minuman',
            'slug' => Str::slug('Minuman'),
        ]);

        $makanan = Category::create([
            'name' => 'Makanan',
            'slug' => Str::slug('Makanan'),
        ]);

        // Create sub-categories for Minuman
        $minumanSubs = [
            'Kopi',
            'Teh'
        ];

        foreach ($minumanSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => Str::slug($sub),
                'parent_id' => $minuman->id
            ]);
        }

        // Create sub-categories for Makanan
        $makananSubs = [
            'Snack',
            'Mie Instan'
        ];

        foreach ($makananSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => Str::slug($sub),
                'parent_id' => $makanan->id
            ]);
        }
    }
}
