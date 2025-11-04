<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyShareholderPosition extends Model
{
    protected $fillable = [
        'company_id',
        'shareholder_entity_id',
        'company_shareholding_id',
        'relationship_type',
        'percent_held',
        'position',
        'market_value',
        'percent_change',
        'report_date',
        'meta',
    ];

    protected $casts = [
        'percent_held' => 'float',
        'market_value' => 'float',
        'percent_change' => 'float',
        'report_date' => 'date',
        'meta' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function entity()
    {
        return $this->belongsTo(ShareholderEntity::class, 'shareholder_entity_id');
    }

    public function shareholding()
    {
        return $this->belongsTo(CompanyShareholding::class, 'company_shareholding_id');
    }
}
