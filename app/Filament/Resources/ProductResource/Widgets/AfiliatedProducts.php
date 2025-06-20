<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AfiliatedProducts extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTerafiliasi = Product::where('status', 'Affiliated')->count();
        $totalTidakTerafiliasi = Product::where('status', 'Unaffiliated')->count();

        $berdasarkanKategori = Product::where('status', 'Affiliated')->select('categories_id')->groupBy('categories_id')->get();
        $totalProduct = Product::count();
        $persentaseTerafiliasi = $totalTerafiliasi > 0 ? round(($totalTerafiliasi / $totalProduct) * 100, 1) : 0;

        return [
            Stat::make('Total Produk', $totalProduct)
            ->description('Jumlah produk terdata')
            // ->descriptionIcon('heroicon-m-shopping-bag')
            ->chart([7, 2, 5, 15, 20])
            ->color('secondary'),

            Stat::make('Produk Terafiliasi', $totalTerafiliasi)
            ->description('Jumlah produk terafiliasi')
            // ->descriptionIcon('heroicon-m-shopping-bag')
            ->chart([20, 15, 7, 2, 10])
            ->color('danger'),

            Stat::make('Produk Bebas Afiliasi', $totalTidakTerafiliasi)
            ->description('Jumlah produk bebas afiliasi')
            // ->descriptionIcon('heroicon-m-shopping-bag')
            ->chart([10, 15, 7, 2, 15])
            ->color('success'),

            // Stat::make('Persentase Terafiliasi', $persentaseTerafiliasi)
            // ->description('Jumlah persentase terafiliasi')
            // ->descriptionIcon('heroicon-o-chart-bar')
            // ->color('warning'),


        ];
    }
}
