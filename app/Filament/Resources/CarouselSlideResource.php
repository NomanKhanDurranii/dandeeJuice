<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarouselSlideResource\Pages;
use App\Models\CarouselSlide;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CarouselSlideResource extends Resource
{
    protected static ?string $model = CarouselSlide::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';

    protected static \UnitEnum|string|null $navigationGroup = 'Catalog';

    protected static ?string $navigationLabel = 'Carousel Slides';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            SpatieMediaLibraryFileUpload::make('slide')
                ->collection('slide')
                ->disk('public')
                ->image()
                ->helperText('Wider images look best — 1920×600 px recommended.')
                ->columnSpanFull(),

            TextInput::make('title')
                ->maxLength(120)
                ->placeholder('e.g. Fresh Juices, Delivered Fast'),

            TextInput::make('subtitle')
                ->maxLength(200)
                ->placeholder('e.g. Cold-pressed, made daily'),

            TextInput::make('button_text')
                ->label('Button Label')
                ->maxLength(40)
                ->placeholder('e.g. Browse Menu'),

            TextInput::make('button_url')
                ->label('Button URL')
                ->url()
                ->placeholder('e.g. /#menu'),

            TextInput::make('order_column')
                ->label('Sort Order')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('slide')
                    ->collection('slide')
                    ->conversion('banner')
                    ->width(160)
                    ->imageHeight(50),
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('subtitle')->limit(50)->toggleable(),
                TextColumn::make('order_column')->label('Order')->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean(),
            ])
            ->defaultSort('order_column')
            ->reorderable('order_column')
            ->bulkActions([
                BulkActionGroup::make([
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
            'index'  => Pages\ListCarouselSlides::route('/'),
            'create' => Pages\CreateCarouselSlide::route('/create'),
            'edit'   => Pages\EditCarouselSlide::route('/{record}/edit'),
        ];
    }
}
