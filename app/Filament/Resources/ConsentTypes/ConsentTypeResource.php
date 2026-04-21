<?php

namespace App\Filament\Resources\ConsentTypes;

use App\Filament\Resources\ConsentTypes\Pages\CreateConsentType;
use App\Filament\Resources\ConsentTypes\Pages\EditConsentType;
use App\Filament\Resources\ConsentTypes\Pages\ListConsentTypes;
use App\Filament\Resources\ConsentTypes\Schemas\ConsentTypeForm;
use App\Filament\Resources\ConsentTypes\Tables\ConsentTypesTable;
use App\Models\COMPILANCE\ConsentType;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class ConsentTypeResource extends Resource
{
    protected static bool $isScopedToTenant = false;
    protected static ?string $model = ConsentType::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ConsentTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConsentTypesTable::configure($table);
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
            'index' => ListConsentTypes::route('/'),
            'create' => CreateConsentType::route('/create'),
            'edit' => EditConsentType::route('/{record}/edit'),
        ];
    }
}
