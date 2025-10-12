<?php

use Illuminate\Support\Str;
use Spatie\LaravelMarkdown\MarkdownRenderer;

function renderWithAnchor(string $markdown): string
{
    $html = app(MarkdownRenderer::class)->toHtml($markdown);

    return preg_replace_callback('/<h([1-6])>(.*?)<\/h\1>/', function ($matches) {
        $level = $matches[1];
        $text = strip_tags($matches[2]);
        $id = Str::slug($text);

        return "<h{$level} id=\"{$id}\">{$matches[2]}</h{$level}>";
    }, $html);
}

function extractToc(string $markdown): array
{
    $headings = [];
    $lines = preg_split('/\r\n|\r|\n/', $markdown);

    foreach ($lines as $line) {
        if (preg_match('/^(#{1,6})\s+(.*)$/', trim($line), $matches)) {
            $level = strlen($matches[1]);
            $text = $matches[2];
            $id = Str::slug($text);

            $headings[] = [
                'level' => (int) $level,
                'text' => $text,
                'id' => $id,
            ];
        }
    }

    return $headings;
}
