<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::with('user')->latest()->limit(8)
            )
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 4, '0', STR_PAD_LEFT))
                    ->weight('bold'),
                TextColumn::make('user.name')->label('Customer')->searchable(),
                TextColumn::make('user.phone')->label('Phone'),
                TextColumn::make('type')->badge()
                    ->color(fn ($state) => $state === 'delivery' ? 'info' : 'success'),
                TextColumn::make('status')->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending'          => 'warning',
                        'confirmed',
                        'preparing',
                        'out_for_delivery' => 'info',
                        'delivered'        => 'success',
                        'cancelled'        => 'danger',
                        default            => 'gray',
                    }),
                TextColumn::make('total')
                    ->money('PKR')
                    ->weight('semibold'),
                TextColumn::make('created_at')
                    ->label('Placed')
                    ->since()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
