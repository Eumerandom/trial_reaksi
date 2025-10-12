<?php

namespace Database\Seeders;

use App\Models\Company;
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
            'status' => 'affiliated',
        ]);

        // Create child companies
        $wingsCompanies = [
            [
                'name' => 'Wings Food',
                'status' => 'affiliated',
            ],
            [
                'name' => 'Wings Care',
                'status' => 'affiliated',
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
                'status' => 'affiliated',
            ],
            [
                'name' => 'PT Sido Muncul Tbk',
                'status' => 'affiliated',
            ],
            [
                'name' => 'PT Dua Kelinci',
                'status' => 'unaffiliated',
            ],
        ];

        foreach ($companies as $company) {
            Company::create([
                'name' => $company['name'],
                'slug' => Str::slug($company['name']),
                'status' => $company['status'],
            ]);
        }
    }
}
