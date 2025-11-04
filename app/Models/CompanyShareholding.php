<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class CompanyShareholding extends Model
{
    protected $fillable = [
        'company_id',
        'symbol',
        'payload',
        'source',
        'cache_store',
        'cache_key',
        'fetched_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'fetched_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(CompanyShareholderPosition::class, 'company_shareholding_id');
    }
}
