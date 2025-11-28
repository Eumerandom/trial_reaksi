<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['status', 'company_id', 'categories_id', 'name', 'description', 'source', 'image', 'slug', 'local_product', 'updated_at'];

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
}
