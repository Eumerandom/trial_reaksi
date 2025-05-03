<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Panduan Lengkap Format Markdown',
                'content' => <<<'MARKDOWN'
# Panduan Lengkap Format Markdown

Selamat datang di panduan lengkap format markdown. Di sini kita akan membahas berbagai format yang didukung.

## Inline Text Formatting

Berikut adalah contoh format teks inline:

- **Teks tebal** menggunakan `**double asterisks**`
- *Teks miring* menggunakan `*single asterisks*`
- ***Tebal dan miring*** menggunakan `***triple asterisks***`
- ~~Teks dicoret~~ menggunakan `~~double tildes~~`
- `Inline code` menggunakan `` `backticks` ``

## Headings

# H1 Heading
## H2 Heading
### H3 Heading
#### H4 Heading
##### H5 Heading
###### H6 Heading

## Lists

### Unordered List
- Item 1
- Item 2
  - Sub-item 2.1
  - Sub-item 2.2
- Item 3

### Ordered List
1. Langkah Pertama
2. Langkah Kedua
   1. Sub-langkah 2.1
   2. Sub-langkah 2.2
3. Langkah Ketiga

### Task List
- [x] Task selesai
- [ ] Task belum selesai
- [x] Task lain yang sudah selesai

## Blockquotes

> Ini adalah blockquote sederhana
> yang bisa memiliki multiple lines
>> Dan juga bisa nested blockquote
>>> Dengan kedalaman yang bisa ditambah

## Code Blocks

### PHP Code
```php
<?php
namespace App\Models;

class Post extends Model
{
    protected $fillable = ['title', 'content'];
    
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
```

### JavaScript Code
```javascript
function greet(name) {
    console.log(`Hello, ${name}!`);
}

greet('Developer');
```

### HTML Code
```html
<div class="container">
    <h1>Hello World</h1>
    <p>This is a paragraph.</p>
</div>
```

## Tables

| Fitur     | Basic | Pro | Enterprise |
|-----------|-------|-----|------------|
| Users     | 10    | 100 | Unlimited  |
| Storage   | 5GB   | 50GB| 500GB      |
| Support   | Email | 24/7| Priority   |
| Price     | $10   | $50 | Contact Us |

## Links

- [Kunjungi Website Kami](https://example.com)
- [Dokumentasi](#dokumentasi)
- [Hubungi Support](mailto:support@example.com)

## Images

![Placeholder Image](https://picsum.photos/800/400)

*Caption: Gambar ilustrasi dari picsum.photos*

## Horizontal Rules

Pemisah dengan tiga dash:

---

Pemisah dengan tiga asterisk:

***

## Escaping Characters

Karakter berikut bisa di-escape dengan backslash:
\* \` \[ \] \( \) \# \+ \- \. \! \{ \} \| \_

## Custom HTML

<div align="center">
  <h3>Center Aligned Heading</h3>
  <p>Dan paragraf yang juga center aligned.</p>
</div>

> **Note**: Markdown mendukung campuran HTML untuk formatting yang lebih kompleks.

## Kesimpulan

Markdown adalah format yang sangat fleksibel dan mudah dibaca, baik dalam bentuk source maupun hasil rendernya.

---

*Terakhir diupdate: Mei 2025*
MARKDOWN,
                'status' => 'published',
                'author' => 1,
                'thumbnail' => 'https://picsum.photos/800/400',
                'slug' => 'panduan-lengkap-format-markdown'
            ],
            [
                'title' => 'Tutorial Penggunaan Markdown di Laravel',
                'content' => <<<'MARKDOWN'
# Tutorial Penggunaan Markdown di Laravel

## Overview

Markdown sangat berguna untuk:
- Dokumentasi
- Blog Posts
- Content Management
- README files

## Instalasi

```bash
composer require league/commonmark
```

## Konfigurasi

```php
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

$environment = new Environment();
$environment->addExtension(new CommonMarkCoreExtension());

$converter = new MarkdownConverter($environment);
$html = $converter->convert($markdown);
```

## Contoh Penggunaan

| Method | Deskripsi | Contoh |
|--------|-----------|--------|
| convert() | Mengubah markdown ke HTML | `$converter->convert($md)` |
| convertToHtml() | Alias dari convert | `$converter->convertToHtml($md)` |

> **Penting**: Selalu escape output HTML untuk mencegah XSS attacks.

### Contoh dalam Blade

```php
{!! Str::markdown($content) !!}
```

## Tips dan Trik

1. Gunakan helper function
2. Cache hasil konversi
3. Validasi input markdown

## Kesimpulan

Laravel + Markdown = ❤️

---

*Happy coding!*
MARKDOWN,
                'status' => 'published',
                'author' => 1,
                'thumbnail' => 'https://picsum.photos/800/400',
                'slug' => 'tutorial-penggunaan-markdown-di-laravel'
            ]
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
