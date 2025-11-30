<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $latestProductUpdate = optional(Product::query()->latest('updated_at')->first())->updated_at;
        $latestPostUpdate = optional(Post::query()->latest('updated_at')->first())->updated_at;
        $latestContentUpdate = collect([$latestProductUpdate, $latestPostUpdate])
            ->filter()
            ->sortByDesc(fn (Carbon $date) => $date->timestamp)
            ->first() ?? now();

        $urls = [
            $this->buildUrl(url('/'), $latestContentUpdate, 'daily', '1.0'),
            $this->buildUrl(route('product.index'), $latestProductUpdate ?? $latestContentUpdate, 'daily', '0.9'),
            $this->buildUrl(route('berita.index'), $latestPostUpdate ?? $latestContentUpdate, 'daily', '0.8'),
        ];

        Product::query()
            ->select(['slug', 'updated_at', 'created_at'])
            ->orderByDesc('updated_at')
            ->lazy()
            ->each(function (Product $product) use (&$urls): void {
                $urls[] = $this->buildUrl(
                    route('product.show', ['slug' => $product->slug]),
                    $product->updated_at ?? $product->created_at,
                    'weekly',
                    '0.7'
                );
            });

        Post::query()
            ->select(['slug', 'updated_at', 'created_at'])
            ->orderByDesc('updated_at')
            ->lazy()
            ->each(function (Post $post) use (&$urls): void {
                $urls[] = $this->buildUrl(
                    route('berita.show', ['slug' => $post->slug]),
                    $post->updated_at ?? $post->created_at,
                    'weekly',
                    '0.6'
                );
            });

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    /**
     * @param  string  $changeFrequency  daily, weekly, etc.
     */
    protected function buildUrl(string $loc, ?Carbon $lastModified, string $changeFrequency, string $priority): array
    {
        return [
            'loc' => $loc,
            'lastmod' => optional($lastModified)->toAtomString(),
            'changefreq' => $changeFrequency,
            'priority' => $priority,
        ];
    }
}
