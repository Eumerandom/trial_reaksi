<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['status_id', 'categories_id', 'name', 'description', 'source', 'image', 'slug', 'local_product', 'updated_at'];

    // relasi ke status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
        // return $this->belongsTo(Status::class, 'status_id');
    }

    // relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
        // return $this->belongsTo(Category::class, 'categories_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) { // $model adalah objek dari model product.
            // Buat slug dari name sebelum disimpan
            if (!$model->slug) { // Mengecek apakah kolom slug belum terisi
                $model->slug = Str::slug($model->name); 
                // Jika kolom slug kosong, maka slug diisi dengan hasil Str::slug($model->name)
                // Fungsi Str::slug() mengubah nilai name menjadi format slug 
            }
        });
    }
}
