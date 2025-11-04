<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShareholderEntity extends Model
{
    protected $fillable = [
        'name',
        'normalized_name',
        'type',
        'status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function positions(): HasMany
    {
        return $this->hasMany(CompanyShareholderPosition::class, 'shareholder_entity_id');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_shareholder_positions')
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
}
