<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public $product;
    public $company;
    public $showShareModal = false;

    public function mount($slug)
    {
        $products = Product::with('company')->where('slug', $slug)->first();
        $company = $products->company;
        $this->company = $company;
        $this->product = $products;
    }

    public function toggleShareModal()
    {
        $this->showShareModal = !$this->showShareModal;
    }

    public function render()
    {
        return view('livewire.product.show');
    }
}
