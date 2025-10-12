<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public $toc;

    public $htmlContent;

    public function mount($slug)
    {
        $this->post = Post::where('slug', $slug)->firstOrFail();
        $this->generateTocAndContent();
    }

    private function generateTocAndContent()
    {
        $markdown = $this->post->content;
        $this->toc = extractToc($markdown);
        $this->htmlContent = renderWithAnchor($markdown);
    }

    public function render()
    {
        return view('livewire.post.show');
    }
}
