<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Support\StatusLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Create parent company
        $wings = Company::create([
            'name' => 'Wings Group',
            'slug' => Str::slug('Wings Group'),
            'status' => StatusLevel::DIRECT_SUPPORT,
        ]);

        // Create child companies
        $wingsCompanies = [
            [
                'name' => 'Wings Food',
                'status' => StatusLevel::INDIRECT_SUPPORT,
            ],
            [
                'name' => 'Wings Care',
                'status' => StatusLevel::DIRECT_SUPPORT,
            ],
        ];

        foreach ($wingsCompanies as $company) {
            Company::create([
                'name' => $company['name'],
                'slug' => Str::slug($company['name']),
                'status' => $company['status'],
                'parent_id' => $wings->id,
            ]);
        }

        $companies = [
            [
                'name' => 'Danone',
                'status' => StatusLevel::DIRECT_SUPPORT,
            ],
            [
                'name' => 'PT Sido Muncul Tbk',
                'status' => StatusLevel::PUBLIC_COMPANY,
            ],
            [
                'name' => 'PT Dua Kelinci',
                'status' => StatusLevel::LOCAL_INDEPENDENT,
            ],
            [
                'name' => 'Microsoft Corporation',
                'status' => StatusLevel::DIRECT_SUPPORT,
                'symbol' => 'MSFT',
            ],
        ];

        foreach ($companies as $company) {
            Company::create([
                'name' => $company['name'],
                'slug' => Str::slug($company['name']),
                'status' => $company['status'],
                'symbol' => $company['symbol'] ?? null,
            ]);
        }
    }
}
