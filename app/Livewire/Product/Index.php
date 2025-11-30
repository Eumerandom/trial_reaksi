<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public bool $open = false;

    public function toggle()
    {
        $this->open = ! $this->open;
    }

    public function viewDetail($slug)
    {
        return redirect()->route('product.show', ['slug' => $slug]);
    }

    public function render()
    {
        $products = Product::with(['category', 'company', 'media'])
            ->select(['id', 'name', 'description', 'status', 'categories_id', 'company_id', 'slug', 'image', 'source', 'local_product'])
            ->get()
            ->map(function ($product) {
                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'status' => $product->status,
                    'status_label' => $product->status === 'affiliated' ? 'Terafiliasi' : 'Tidak Terafiliasi',
                    'category' => $product->category ? (object) [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                    ] : null,
                    'company' => $product->company ? (object) [
                        'id' => $product->company->id,
                        'name' => $product->company->name,
                    ] : null,
                    'slug' => $product->slug,
                    'image' => $product->image_url,
                    'source' => $product->source,
                    'local_product' => $product->local_product,
                    'is_local' => $product->local_product ? 'Produk Lokal' : 'Produk Import',
                ];
            });

        $categories = Category::select(['id', 'name'])->get();
        $companies = Company::select(['id', 'name'])->get();

        return view('livewire.product.index', [
            'products' => $products,
            'categories' => $categories,
            'companies' => $companies,
        ]);
    }
}
