<?php

namespace App\Filament\Resources\Dpas;

use App\Filament\Resources\Dpas\Pages\CreateDpa;
use App\Filament\Resources\Dpas\Pages\EditDpa;
use App\Filament\Resources\Dpas\Pages\ListDpas;
use App\Filament\Resources\Dpas\Schemas\DpaForm;
use App\Filament\Resources\Dpas\Tables\DpasTable;
use App\Models\COMPILANCE\Dpa;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class DpaResource extends Resource
{
    protected static ?string $model = Dpa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DpaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DpasTable::configure($table);
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
            'index' => ListDpas::route('/'),
            'create' => CreateDpa::route('/create'),
            'edit' => EditDpa::route('/{record}/edit'),
        ];
    }
}
