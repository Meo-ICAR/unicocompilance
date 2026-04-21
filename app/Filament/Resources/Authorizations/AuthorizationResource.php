<?php

namespace App\Filament\Resources\Authorizations;

use App\Filament\Resources\Authorizations\Pages\CreateAuthorization;
use App\Filament\Resources\Authorizations\Pages\EditAuthorization;
use App\Filament\Resources\Authorizations\Pages\ListAuthorizations;
use App\Filament\Resources\Authorizations\Schemas\AuthorizationForm;
use App\Filament\Resources\Authorizations\Tables\AuthorizationsTable;
use App\Models\COMPILANCE\Authorization;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class AuthorizationResource extends Resource
{
    protected static ?string $model = Authorization::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AuthorizationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuthorizationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthorizations::route('/'),
            'create' => CreateAuthorization::route('/create'),
            'edit' => EditAuthorization::route('/{record}/edit'),
        ];
    }
}
