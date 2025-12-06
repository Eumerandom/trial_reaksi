<?php

namespace App\Filament\Imports;

use App\Models\Company;
use App\Support\StatusLevel;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class CompanyImporter extends Importer
{
    protected static ?string $model = Company::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('symbol')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:20'])
                ->example('AALI')
                ->guess(['code', 'kode', 'ticker', 'symbol', 'kode_saham'])
                ->helperText('Kode saham perusahaan (contoh: AALI, BBCA)'),

            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->example('Astra Agro Lestari Tbk.')
                ->guess(['nama', 'company_name', 'nama_perusahaan', 'emiten'])
                ->helperText('Nama lengkap perusahaan'),
        ];
    }

    public function resolveRecord(): ?Company
    {
        return Company::query()
            ->firstOrNew(['symbol' => strtoupper(trim($this->data['symbol']))]);
    }

    protected function beforeSave(): void
    {
        if (! $this->record->exists) {
            $this->record->slug = Str::slug($this->data['name']).'-'.strtolower($this->data['symbol']);
            $this->record->status = StatusLevel::PUBLIC_COMPANY; // Default untuk perusahaan Tbk
        }

        $this->record->symbol = strtoupper(trim($this->data['symbol']));
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import perusahaan selesai! '.Number::format($import->successful_rows).' '.str('baris')->plural($import->successful_rows).' berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('baris')->plural($failedRowsCount).' gagal.';
        }

        return $body;
    }
}
