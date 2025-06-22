<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $table = 'companies';
    protected $fillable = ['name', 'slug', 'parent_id', 'status', 'logo'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Company::class, 'parent_id', 'id');
    }

    public function getParents()
    {
        $parents = [];
        $current = $this;
        while ($current->parent) {
            $parents[] = $current->parent;
            $current = $current->parent;
        }
        return $parents;
    }


}
