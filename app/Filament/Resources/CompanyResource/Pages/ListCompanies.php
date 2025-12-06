<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Imports\CompanyImporter;
use App\Filament\Resources\CompanyResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(CompanyImporter::class)
                ->label('Import CSV'),
            CreateAction::make(),
        ];
    }
}
