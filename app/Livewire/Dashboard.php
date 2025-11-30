<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Support\StatusLevel;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $alternativeProductCount = Product::whereIn('status', StatusLevel::safeValues())->count();

        $categoryCount = Category::count();

        $localProductCount = Product::where('local_product', 1)->count();

        return view('dashboard', [
            'alternativeProductCount' => $alternativeProductCount,
            'categoryCount' => $categoryCount,
            'localProductCount' => $localProductCount,
        ]);
    }
}
