<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('category.name')->label('Category'),
            ExportColumn::make('name')->label('Product Name'),
            ExportColumn::make('description')->label('Description'),
            ExportColumn::make('price')->label('Price (PKR)'),
            ExportColumn::make('is_active')->label('Active')->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),
            ExportColumn::make('order_column')->label('Sort Order'),
            ExportColumn::make('created_at')->label('Added'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $count = number_format($export->successful_rows);
        return "Products export ready — {$count} " . str('product')->plural($export->successful_rows) . ' exported.';
    }
}
