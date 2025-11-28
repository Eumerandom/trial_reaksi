<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use App\Filament\Resources\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(ProductImporter::class)
                ->label('Import Produk')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->maxRows(5000)
                ->chunkSize(100),

            ExportAction::make()
                ->exporter(ProductExporter::class)
                ->label('Export Produk')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray'),

            CreateAction::make(),
        ];
    }
}
