<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    protected static \UnitEnum|string|null $navigationGroup = 'Users';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),

            TextInput::make('phone')
                ->tel()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('email')
                ->email()
                ->nullable()
                ->unique(ignoreRecord: true),

            Select::make('role')
                ->options([
                    'super_admin' => 'Super Admin',
                    'manager' => 'Manager',
                    'customer' => 'Customer',
                ])
                ->required(),

            TextInput::make('password')
                ->password()
                ->nullable()
                ->helperText('Leave blank to keep unchanged. Required for admin panel access.')
                ->dehydrated(fn ($state) => filled($state))
                ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('role')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'super_admin' => 'danger',
                        'manager' => 'warning',
                        'customer' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('orders_count')->label('Orders')->counts('orders'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('role')->options([
                    'super_admin' => 'Super Admin',
                    'manager' => 'Manager',
                    'customer' => 'Customer',
                ]),
            ])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
