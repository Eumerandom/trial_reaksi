<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AfiliatedProducts extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTerafiliasi = Product::where('status', 'afiliated')->count();

        $berdasarkanKategori = Product::where('status', 'afiliated')->select('categories_id')->groupBy('categories_id')->get();

        $totalProduct = Product::count();
        $persentaseTerafiliasi = $totalTerafiliasi > 0 ? round(($totalTerafiliasi / $totalProduct) * 100, 1) : 0;

        return [
            Stat::make('Total Produk Terafiliasi', $totalTerafiliasi)
            ->description('Jumlah produk terafiliasi')
            ->descriptionIcon('heroicon-m-shopping-bag')
            ->color('danger'),

            Stat::make('Persentase Terafiliasi', $persentaseTerafiliasi)
            ->description('Jumlah persentase terafiliasi')
            ->descriptionIcon('heroicon-o-chart-bar')
            ->color('warning'),


        ];
    }
}
