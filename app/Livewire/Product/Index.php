<?php

namespace App\Livewire\Product;

// use App\Models\Status;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public bool $open = false;
    public $filterStatus;
    public $filterCategory;
    public $search;
    public $layout = 'grid'; // grid atau list

    public function setLayout($type)
    {
        $this->layout = $type;
    }
    public function toggle()
    {
        $this->open = !$this->open;
    }


    public function render()
    {
        $products = Product::query();

        if ($this->filterStatus) {
            $products->where('status', $this->filterStatus);
        }

        if ($this->filterCategory) {
            $products->whereHas('category', function ($query) {
               $query->where( 'name', $this->filterCategory );
            });
        }

        if ($this->search) {
            $products->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });

                if (strtolower($this->search) === 'local') {
                    $query->orWhere('local_product', 1);
                }
            });
        }

        return view('livewire.product.index',
        [
            // 'products'=>Product::get(),
            'products'=>$products->paginate(),
            // 'statuses'=>Status::get(),
            'companies'=>Company::get(),
            'categories'=>Category::get(),

        ]
    );
    }
}
