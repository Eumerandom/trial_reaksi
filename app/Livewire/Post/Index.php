<?php

namespace App\Livewire\Post;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterCategory = '';
    public $sort = 'asc';
    public $open = false;
    public $layout = 'grid';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'sort' => ['except' => 'asc'],
    ];

    public function toggle()
    {
        $this->open = !$this->open;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query, $filterStatus) {
                if ($filterStatus == 'affiliated') {
                    $query->where('status', 'affiliated'); // Sesuaikan dengan kolom status yang sesuai
                } else {
                    $query->where('status', 'unaffiliated'); // Sesuaikan dengan kolom status yang sesuai
                }
            })
            ->when($this->filterCategory, function ($query, $filterCategory) {
                $query->whereHas('category', function ($query) use ($filterCategory) {
                    $query->where('name', $filterCategory);
                });
            })
            ->orderBy('title', $this->sort)
            ->paginate(12);

        $categories = \App\Models\Category::all();

        return view('livewire.post.index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
}
