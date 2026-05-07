<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TrendingProductsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Trending Products';

    public function getTableRecordKey(Model|array $record): string
    {
        return (string) (is_array($record) ? $record['product_name'] : $record->product_name);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderItem::query()
                    ->selectRaw('product_name, SUM(quantity) as total_sold, SUM(subtotal) as total_revenue, COUNT(DISTINCT order_id) as order_count')
                    ->groupBy('product_name')
                    ->orderByDesc('total_sold')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('total_sold')
                    ->label('Units Sold')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                TextColumn::make('order_count')
                    ->label('Orders')
                    ->sortable(),
                TextColumn::make('total_revenue')
                    ->label('Revenue')
                    ->formatStateUsing(fn ($state) => 'PKR ' . number_format($state))
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
