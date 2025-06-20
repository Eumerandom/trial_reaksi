<?php

namespace App\Livewire\Post;

use Livewire\Component;
use App\Models\Post;
use TOC\TocGenerator;
use TOC\MarkupFixer;
use Illuminate\Support\Facades\Log;
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
        $this->htmlContent = \Illuminate\Support\Str::markdown($this->post->content);
        
        $markupFixer = new MarkupFixer();
        $tocGenerator = new TocGenerator();
        $fixedContent = $markupFixer->fix($this->htmlContent);
    
        $this->toc = $tocGenerator->getHtmlMenu($fixedContent); 
    }

    public function render()
    {
        return view('livewire.post.show');
    }
}
