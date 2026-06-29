<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Store;
use App\Models\StoreOrder;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EcommerceStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 5;

    protected ?string $heading = 'E-commerce by Conweb';

    protected function getStats(): array
    {
        $activeStores = Store::where('is_active', true)->count();
        $totalStores = Store::count();
        $products = Product::count();
        $orders = StoreOrder::count();
        // GMV = total order yang tidak dibatalkan.
        $gmv = (int) StoreOrder::where('status', '!=', 'cancelled')->sum('total');

        return [
            Stat::make('Toko Aktif', $activeStores)
                ->description($totalStores.' toko total')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('success'),
            Stat::make('Total Produk', number_format($products, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-cube'),
            Stat::make('Total Order', number_format($orders, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-shopping-bag'),
            Stat::make('GMV (Omzet)', formatRupiah($gmv))
                ->description('Di luar order dibatalkan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
