<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Branch;
use App\Models\DeliveryZone;
use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static \UnitEnum|string|null $navigationGroup = 'Orders';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = Order::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')
                ->options([
                    'pending'          => 'Pending',
                    'confirmed'        => 'Confirmed',
                    'preparing'        => 'Preparing',
                    'out_for_delivery' => 'Out for Delivery',
                    'delivered'        => 'Delivered',
                    'cancelled'        => 'Cancelled',
                ])
                ->required(),

            Select::make('payment_method')
                ->options([
                    'cod'       => 'Cash on Delivery',
                    'easypaisa' => 'EasyPaisa',
                    'jazzcash'  => 'JazzCash',
                ])
                ->required(),

            Select::make('pickup_branch_id')
                ->label('Pickup Branch')
                ->options(fn () => Branch::activeOrdered()->pluck('name', 'id')->toArray())
                ->searchable()
                ->hidden(fn (?Order $record) => $record?->type !== 'pickup'),

            Select::make('delivery_zone_id')
                ->label('Delivery Zone')
                ->options(fn () => DeliveryZone::activeOrdered()->pluck('name', 'id')->toArray())
                ->searchable()
                ->hidden(fn (?Order $record) => $record?->type !== 'delivery'),

            Textarea::make('notes')->rows(3)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 4, '0', STR_PAD_LEFT))
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.name')->label('Customer')->searchable()->sortable(),
                TextColumn::make('user.phone')->label('Phone')->searchable(),
                TextColumn::make('type')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'delivery' => 'info',
                        'pickup'   => 'success',
                        default    => 'gray',
                    }),
                TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending'                              => 'warning',
                        'confirmed', 'preparing',
                        'out_for_delivery'                    => 'info',
                        'delivered'                           => 'success',
                        'cancelled'                           => 'danger',
                        default                               => 'gray',
                    }),
                TextColumn::make('total')->money('PKR')->sortable(),
                TextColumn::make('payment_method')->badge(),
                TextColumn::make('location')
                    ->label('Location')
                    ->getStateUsing(function (Order $record): string {
                        if ($record->type === 'delivery') {
                            return $record->deliveryZone?->name ?? $record->delivery_address ?? '—';
                        }
                        return $record->pickupBranch?->name ?? $record->delivery_address ?? '—';
                    })
                    ->description(fn (Order $record): string => $record->type === 'delivery' ? 'Delivery Zone' : 'Pickup Branch')
                    ->toggleable(),
                TextColumn::make('created_at')->dateTime()->sortable()->label('Placed')->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options([
                    'pending'          => 'Pending',
                    'confirmed'        => 'Confirmed',
                    'preparing'        => 'Preparing',
                    'out_for_delivery' => 'Out for Delivery',
                    'delivered'        => 'Delivered',
                    'cancelled'        => 'Cancelled',
                ]),
                SelectFilter::make('type')->options([
                    'delivery' => 'Delivery',
                    'pickup'   => 'Pickup',
                ]),
            ])
            ->actions([
                // Quick status transitions
                Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->visible(fn (Order $record) => $record->status === 'pending')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'confirmed']);
                        Notification::make()->title('Order confirmed')->success()->send();
                    }),

                Action::make('preparing')
                    ->label('Preparing')
                    ->icon('heroicon-m-fire')
                    ->color('warning')
                    ->visible(fn (Order $record) => $record->status === 'confirmed')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'preparing']);
                        Notification::make()->title('Marked as preparing')->success()->send();
                    }),

                Action::make('out_for_delivery')
                    ->label('Out for Delivery')
                    ->icon('heroicon-m-truck')
                    ->color('info')
                    ->visible(fn (Order $record) => in_array($record->status, ['confirmed', 'preparing']) && $record->type === 'delivery')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'out_for_delivery']);
                        Notification::make()->title('Out for delivery')->success()->send();
                    }),

                Action::make('delivered')
                    ->label('Delivered ✓')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->visible(fn (Order $record) => in_array($record->status, ['preparing', 'out_for_delivery', 'confirmed']))
                    ->requiresConfirmation()
                    ->action(function (Order $record) {
                        $record->update(['status' => 'delivered']);
                        Notification::make()->title('Order delivered!')->success()->send();
                    }),

                Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->visible(fn (Order $record) => ! in_array($record->status, ['delivered', 'cancelled']))
                    ->requiresConfirmation()
                    ->action(function (Order $record) {
                        $record->update(['status' => 'cancelled']);
                        Notification::make()->title('Order cancelled')->warning()->send();
                    }),

                EditAction::make()->label('Edit'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(OrderExporter::class)->label('Export CSV'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->exporter(OrderExporter::class),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
