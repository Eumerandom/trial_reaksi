<?php

namespace App\Jobs;

use App\Models\Company;
use App\Services\CompanyShareholdingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchCompanyShareholding implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly int $companyId,
        public readonly ?string $region = null,
        public readonly ?string $lang = null,
    ) {}

    public function handle(CompanyShareholdingService $service): void
    {
        $company = Company::query()->find($this->companyId);

        if (! $company) {
            Log::warning('shareholdings.job.company_missing', [
                'company_id' => $this->companyId,
            ]);

            return;
        }

        if (empty($company->symbol)) {
            Log::warning('shareholdings.job.symbol_missing', [
                'company_id' => $company->id,
                'company_name' => $company->name,
            ]);

            return;
        }

        $service->fetchAndStore(
            $company,
            $this->region,
            $this->lang
        );
    }
}
