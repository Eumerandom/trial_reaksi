<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $alternativeProductCount = Product::where('status', 'unaffiliated')->count();
        
        $categoryCount = Category::count();
        
        $localProductCount = Product::where('local_product', 1)->count();
        
        return view('dashboard', [
            'alternativeProductCount' => $alternativeProductCount,
            'categoryCount' => $categoryCount,
            'localProductCount' => $localProductCount,
        ]);
    }
}
