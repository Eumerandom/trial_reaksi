<?php

namespace App\Filament\Resources\ShareholderEntityResource\Pages;

use App\Filament\Resources\ShareholderEntityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShareholderEntities extends ListRecords
{
    protected static string $resource = ShareholderEntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
