<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;
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

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value, array $attributes): ?string {
                $media = $this->ensureProductImageWebp();

                if ($media) {
                    return $media->getUrl();
                }

                // Fallback ke external image URL jika ada
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
        $media = $this->ensureProductImageWebp();

        if (! $media) {
            return;
        }

        $mediaUrl = $media->getUrl();

        if ($this->image === $mediaUrl) {
            return;
        }

        $this->forceFill(['image' => $mediaUrl])->saveQuietly();
    }

    protected function ensureProductImageWebp(?Media $media = null): ?Media
    {
        $media ??= $this->getFirstMedia('product_images');

        if (! $media) {
            return null;
        }

        $this->deletePreviewConversion($media);

        if (Str::of($media->file_name)->lower()->endsWith('.webp')) {
            return $media->refresh();
        }

        try {
            $disk = Storage::disk($media->disk);

            $originalRelativePath = $media->getPathRelativeToRoot();
            $originalAbsolutePath = $media->getPath();

            $extension = pathinfo($media->file_name, PATHINFO_EXTENSION);
            $webpFileName = $extension
                ? Str::of($media->file_name)->replaceLast('.'.$extension, '.webp')->toString()
                : $media->file_name.'.webp';

            $webpRelativePath = Str::of($originalRelativePath)
                ->replaceLast($media->file_name, $webpFileName)
                ->toString();

            $webpAbsolutePath = $disk->path($webpRelativePath);

            Image::useImageDriver(config('media-library.image_driver', 'gd'))
                ->loadFile($originalAbsolutePath)
                ->format('webp')
                ->quality(90)
                ->save($webpAbsolutePath);

            $disk->delete($originalRelativePath);

            $media->forceFill([
                'file_name' => $webpFileName,
                'mime_type' => 'image/webp',
                'size' => $disk->size($webpRelativePath),
                'generated_conversions' => [],
            ])->save();

            return $media->fresh();
        } catch (\Throwable $exception) {
            report($exception);

            return $media;
        }
    }

    protected function deletePreviewConversion(Media $media): void
    {
        $conversionDisk = $media->conversions_disk ?? $media->disk;
        $disk = Storage::disk($conversionDisk);

        $baseName = pathinfo($media->file_name, PATHINFO_FILENAME);
        $previewFileName = $baseName.'-preview.webp';

        $previewRelativePath = Str::of($media->getPathRelativeToRoot())
            ->replace($media->file_name, $previewFileName)
            ->toString();

        if ($disk->exists($previewRelativePath)) {
            $disk->delete($previewRelativePath);
        }
    }
}
