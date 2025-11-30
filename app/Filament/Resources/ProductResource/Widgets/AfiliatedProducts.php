<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use App\Support\StatusLevel;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AfiliatedProducts extends BaseWidget
{
    protected function getStats(): array
    {
        $definitions = StatusLevel::definitions();
        $counts = Product::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalProduct = Product::count();

        $stats = [
            Stat::make('Total Produk', $totalProduct)
                ->description('Seluruh produk yang sudah dikurasi')
                ->color('secondary'),
        ];

        foreach ($definitions as $status => $definition) {
            $stats[] = Stat::make(
                'Level '.$definition['level'].': '.$definition['label'],
                (int) ($counts[$status] ?? 0)
            )
                ->description($definition['cta'])
                ->color($definition['filament_color']);
        }

        return $stats;
    }
}
