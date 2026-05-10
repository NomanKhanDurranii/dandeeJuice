<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Branches';

    protected static ?string $modelLabel = 'Branch';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Branch Name')
                ->placeholder('e.g. DHA Phase 5 Branch')
                ->required()
                ->maxLength(120),

            Textarea::make('address')
                ->label('Full Address')
                ->placeholder('e.g. Shop 5, Street 6, Badar Commercial, DHA Phase 5, Karachi')
                ->required()
                ->rows(2),

            TextInput::make('phone')
                ->label('Phone Number')
                ->placeholder('e.g. 0300-1234567')
                ->tel()
                ->maxLength(30),

            TextInput::make('whatsapp')
                ->label('WhatsApp Number (with country code, no +)')
                ->placeholder('e.g. 923001234567')
                ->helperText('Used for WhatsApp links. Falls back to phone if blank.')
                ->maxLength(30),

            TextInput::make('google_maps_url')
                ->label('Google Maps Link')
                ->placeholder('https://maps.google.com/?q=...')
                ->url()
                ->maxLength(500)
                ->columnSpanFull(),

            TextInput::make('sort_order')
                ->label('Sort Order')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Visible to customers')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('#')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('address')->limit(50)->wrap(),
                TextColumn::make('phone')->label('Phone'),
                IconColumn::make('is_active')->label('Active')->boolean(),
                TextColumn::make('updated_at')->label('Updated')->since()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit'   => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
