<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use App\Models\Lead;
use App\Models\Order;
use App\Models\WebTemplate;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pendapatan (Lunas)', 'Rp'.number_format(Order::where('payment_status', 'paid')->sum('total_amount'), 0, ',', '.'))
                ->description(Order::where('payment_status', 'paid')->count().' pesanan lunas')
                ->color('success')
                ->icon('heroicon-o-banknotes'),
            Stat::make('Menunggu Pembayaran', Order::where('payment_status', 'pending')->count())
                ->description('Pesanan domain + template belum dibayar')
                ->color('warning')
                ->icon('heroicon-o-clock'),
            Stat::make('Pesan Cepat (Lead)', Lead::count())
                ->description('Baru: '.Lead::where('status', 'new')->count())
                ->color('primary')
                ->icon('heroicon-o-inbox-stack'),
            Stat::make('Template Aktif', WebTemplate::where('is_active', true)->count())
                ->description('Total template di galeri')
                ->color('info')
                ->icon('heroicon-o-swatch'),
            Stat::make('Artikel Blog', BlogPost::where('is_active', true)->count())
                ->description('Artikel terpublikasi')
                ->color('gray')
                ->icon('heroicon-o-newspaper'),
        ];
    }
}
