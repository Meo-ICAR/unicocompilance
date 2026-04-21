<?php

namespace App\Filament\Resources\ClientDpas;

use App\Filament\Resources\ClientDpas\Pages\CreateClientDpa;
use App\Filament\Resources\ClientDpas\Pages\EditClientDpa;
use App\Filament\Resources\ClientDpas\Pages\ListClientDpas;
use App\Filament\Resources\ClientDpas\Schemas\ClientDpaForm;
use App\Filament\Resources\ClientDpas\Tables\ClientDpasTable;
use App\Models\COMPILANCE\ClientDpa;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class ClientDpaResource extends Resource
{
    protected static ?string $model = ClientDpa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ClientDpaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientDpasTable::configure($table);
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
            'index' => ListClientDpas::route('/'),
            'create' => CreateClientDpa::route('/create'),
            'edit' => EditClientDpa::route('/{record}/edit'),
        ];
    }
}
