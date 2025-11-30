<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('name')
                ->label('Nama Produk'),

            ExportColumn::make('slug')
                ->label('Slug'),

            ExportColumn::make('description')
                ->label('Deskripsi'),

            ExportColumn::make('company.name')
                ->label('Nama Perusahaan'),

            ExportColumn::make('company.symbol')
                ->label('Simbol Perusahaan'),

            ExportColumn::make('category.name')
                ->label('Kategori'),

            ExportColumn::make('status')
                ->label('Status Afiliasi')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'affiliated' => 'Afiliasi',
                    'unaffiliated' => 'Tidak Afiliasi',
                    default => $state,
                }),

            ExportColumn::make('local_product')
                ->label('Produk Lokal')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),

            ExportColumn::make('source')
                ->label('Sumber URL'),

            ExportColumn::make('image_url')
                ->label('URL Gambar'),

            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),

            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export produk selesai! '.Number::format($export->successful_rows).' '.str('baris')->plural($export->successful_rows).' berhasil diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('baris')->plural($failedRowsCount).' gagal diexport.';
        }

        return $body;
    }
}
