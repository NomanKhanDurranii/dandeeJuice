<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ProductExporter;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static \UnitEnum|string|null $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('category_id')
                ->relationship('category', 'name')
                ->required()
                ->searchable()
                ->preload(),

            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->label('URL Slug')
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Auto-generated from name. Edit to customize the URL.')
                ->placeholder('auto-generated'),

            TextInput::make('price')
                ->label('Base Price (PKR)')
                ->required()
                ->numeric()
                ->prefix('PKR')
                ->minValue(0)
                ->helperText('Used when no size variants are defined.'),

            TextInput::make('order_column')
                ->label('Sort Order')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Active')
                ->default(true),

            RichEditor::make('description')
                ->columnSpanFull()
                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),

            SpatieMediaLibraryFileUpload::make('images')
                ->collection('images')
                ->disk('public')
                ->multiple()
                ->reorderable()
                ->image()
                ->columnSpanFull(),

            Repeater::make('variants')
                ->relationship('variants')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->placeholder('e.g. Single Scoop')
                        ->columnSpan(2),

                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('PKR')
                        ->minValue(0)
                        ->columnSpan(2),

                    TextInput::make('order_column')
                        ->label('Order')
                        ->numeric()
                        ->default(0)
                        ->columnSpan(1),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->columnSpan(1),
                ])
                ->columns(6)
                ->addActionLabel('+ Add Size Variant')
                ->orderColumn('order_column')
                ->columnSpanFull()
                ->label('Size Variants')
                ->helperText('Optional — add variants like Single/Double/Triple Scoop with separate prices. When variants exist, the base price above is ignored on the storefront.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->circular(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('category.name')->badge()->sortable(),
                TextColumn::make('price')->money('PKR')->sortable(),
                TextColumn::make('variants_count')
                    ->label('Variants')
                    ->counts('variants')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray'),
                TextColumn::make('order_column')->label('Order')->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order_column')
            ->reorderable('order_column')
            ->filters([
                SelectFilter::make('category')->relationship('category', 'name'),
                SelectFilter::make('is_active')
                    ->options([1 => 'Active', 0 => 'Inactive'])
                    ->label('Status'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ProductExporter::class)->label('Export CSV'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->exporter(ProductExporter::class),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
