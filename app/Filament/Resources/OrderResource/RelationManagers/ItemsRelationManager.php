<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Order Items';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('product_price')
                    ->label('Unit Price')
                    ->money('PKR'),
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->alignCenter(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('PKR')
                    ->weight('semibold'),
            ])
            ->paginated(false);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }
}
