<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public $product;

    public $company;

    public $parents = [];

    public $showShareModal = false;

    public function mount($slug)
    {
        $products = Product::with('company')->where('slug', $slug)->first();
        $company = $products->company->load(['children', 'children.children']);
        $this->parents = $company->getParents();
        $this->company = $company;
        $this->product = $products;

    }

    public function toggleShareModal()
    {
        $this->showShareModal = ! $this->showShareModal;
    }

    public function render()
    {
        return view('livewire.product.show');
    }
}
