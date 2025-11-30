<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $table = 'companies';

    protected $fillable = ['name', 'slug', 'symbol', 'parent_id', 'status', 'logo'];

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

    public function getTotalChildren()
    {
        $total = $this->children->count();
        foreach ($this->children as $child) {
            $total += $child->getTotalChildren();
        }

        return $total;
    }

    public function shareholdings(): HasMany
    {
        return $this->hasMany(CompanyShareholding::class);
    }

    public function shareholderPositions(): HasMany
    {
        return $this->hasMany(CompanyShareholderPosition::class);
    }

    public function shareholderEntities(): BelongsToMany
    {
        return $this->belongsToMany(ShareholderEntity::class, 'company_shareholder_positions')
            ->withPivot([
                'percent_held',
                'market_value',
                'percent_change',
                'report_date',
                'relationship_type',
                'company_shareholding_id',
            ])
            ->withTimestamps();
    }

    public function latestShareholding(): HasOne
    {
        return $this->hasOne(CompanyShareholding::class)->latestOfMany('fetched_at');
    }
}
