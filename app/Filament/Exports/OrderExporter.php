<?php

namespace App\Filament\Exports;

use App\Models\Order;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OrderExporter extends Exporter
{
    protected static ?string $model = Order::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('Order ID'),
            ExportColumn::make('user.name')->label('Customer'),
            ExportColumn::make('user.email')->label('Email'),
            ExportColumn::make('user.phone')->label('Phone'),
            ExportColumn::make('type')->label('Type'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('payment_method')->label('Payment'),
            ExportColumn::make('delivery_address')->label('Zone'),
            ExportColumn::make('subtotal')->label('Subtotal'),
            ExportColumn::make('delivery_fee')->label('Delivery Fee'),
            ExportColumn::make('total')->label('Total'),
            ExportColumn::make('notes')->label('Notes'),
            ExportColumn::make('created_at')->label('Placed At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $count = number_format($export->successful_rows);
        return "Your orders export is ready — {$count} " . str('order')->plural($export->successful_rows) . ' exported.';
    }
}
