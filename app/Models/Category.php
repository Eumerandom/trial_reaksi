<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id'];

    public function products()
    {
        return $this->hasMany(Product::class, 'categories_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByName', function ($query) {
            $query->orderBy('name', 'asc'); // menyortir secara ascending A-Z
        });

        static::creating(function ($model) { // $model adalah objek dari model Jenis.
            // Buat slug dari name sebelum disimpan
            if (! $model->slug) { // Mengecek apakah kolom slug belum terisi
                $model->slug = Str::slug($model->name);
                // Jika kolom slug kosong, maka slug diisi dengan hasil Str::slug($model->name)
                // Fungsi Str::slug() mengubah nilai name menjadi format slug
            }
        });
    }
}
