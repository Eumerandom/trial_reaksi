<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Status extends Model
{
    /** @use HasFactory<\Database\Factories\StatusFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class, 'status_id');
        // return $this->hasMany(Product::class, 'status_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) { // $model adalah objek dari model Jenis.
            // Buat slug dari name sebelum disimpan
            if (!$model->slug) { // Mengecek apakah kolom slug belum terisi
                $model->slug = Str::slug($model->name); 
                // Jika kolom slug kosong, maka slug diisi dengan hasil Str::slug($model->name)
                // Fungsi Str::slug() mengubah nilai name menjadi format slug 
            }
        });
    }
}
