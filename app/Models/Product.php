<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = ['status', 'company_id', 'categories_id', 'name', 'description', 'source', 'image', 'slug', 'local_product', 'updated_at'];

    protected $attributes = [
        'image' => '',
    ];

    protected $appends = ['image_url'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) { // $model adalah objek dari model product.
            // Buat slug dari name sebelum disimpan
            if (! $model->slug) { // Mengecek apakah kolom slug belum terisi
                $model->slug = Str::slug($model->name);
                // Jika kolom slug kosong, maka slug diisi dengan hasil Str::slug($model->name)
                // Fungsi Str::slug() mengubah nilai name menjadi format slug
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $previewQuality = (int) config('media-library.conversions.product_preview_webp_quality', 80);

        $this->addMediaConversion('preview')
            ->performOnCollections('product_images')
            ->fit(Fit::Crop, 600, 600)
            ->keepOriginalImageFormat()
            ->nonQueued();

        $this->addMediaConversion('preview_webp')
            ->performOnCollections('product_images')
            ->fit(Fit::Crop, 600, 600)
            ->format('webp')
            ->quality($previewQuality)
            ->nonQueued();
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value, array $attributes): ?string {
                $mediaUrl = $this->getFirstMediaUrl('product_images', 'preview')
                    ?: $this->getFirstMediaUrl('product_images');

                if ($mediaUrl) {
                    return $mediaUrl;
                }

                $imagePath = $attributes['image'] ?? null;

                if (blank($imagePath)) {
                    return null;
                }

                if (Str::startsWith($imagePath, ['http://', 'https://'])) {
                    return $imagePath;
                }

                return Storage::disk('public')->url($imagePath);
            },
        );
    }

    public function syncImageColumnFromMedia(): void
    {
        $mediaUrl = $this->getFirstMediaUrl('product_images');

        if (! $mediaUrl || $this->image === $mediaUrl) {
            return;
        }

        $this->forceFill(['image' => $mediaUrl])->saveQuietly();
    }
}
