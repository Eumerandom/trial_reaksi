<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'status', 'author', 'slug', 'thumbnail'];

    public function authorUser()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
