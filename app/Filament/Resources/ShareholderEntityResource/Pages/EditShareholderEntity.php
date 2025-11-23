<?php

namespace App\Filament\Resources\ShareholderEntityResource\Pages;

use App\Filament\Resources\ShareholderEntityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShareholderEntity extends EditRecord
{
    protected static string $resource = ShareholderEntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
