<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todayRevenue = Order::whereDate('created_at', today())
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');

        $pendingOrders = Order::where('status', 'pending')->count();

        return [
            Stat::make('Total Orders', Order::count())
                ->description('All time')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Pending Orders', $pendingOrders)
                ->description('Awaiting confirmation')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'success'),

            Stat::make("Today's Revenue", 'PKR ' . number_format($todayRevenue))
                ->description('Confirmed orders')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('New Inquiries', Inquiry::where('status', 'new')->count())
                ->description('Unread messages')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
        ];
    }
}
