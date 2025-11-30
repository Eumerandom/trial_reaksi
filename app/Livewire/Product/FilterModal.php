<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Company;
use App\Support\StatusLevel;
use Livewire\Component;

class FilterModal extends Component
{
    public $filters = [
        'category' => '',
        'company' => '',
        'status' => '',
        'localProduct' => '',
    ];

    public function render()
    {
        $categories = Category::select(['id', 'name'])->get();
        $companies = Company::select(['id', 'name'])->get();

        return view('livewire.product.filter-modal', [
            'categories' => $categories,
            'companies' => $companies,
            'statusOptions' => StatusLevel::dropdownItems(),
        ]);
    }

    public function clearFilters()
    {
        $this->filters = [
            'category' => '',
            'company' => '',
            'status' => '',
            'localProduct' => '',
        ];

        $this->dispatch('filtersCleared', $this->filters);
    }

    public function applyFilters()
    {
        $this->dispatch('filtersApplied', $this->filters);
    }

    public function updated($property, $value)
    {
        if (str_starts_with($property, 'filters.')) {
            $this->applyFilters();
        }
    }
}
