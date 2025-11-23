<?php

use App\Jobs\FetchCompanyShareholding;
use App\Models\Company;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Company::query()
        ->whereNotNull('symbol')
        ->chunkById(50, function ($companies) {
            foreach ($companies as $company) {
                FetchCompanyShareholding::dispatch($company->id);
            }
        });
})
    ->name('shareholdings:fetch-daily')
    ->dailyAt('02:00')
    ->withoutOverlapping();
