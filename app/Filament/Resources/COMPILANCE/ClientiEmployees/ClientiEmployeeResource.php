<?php

namespace App\Filament\Resources\COMPILANCE\ClientiEmployees;

use App\Filament\Resources\COMPILANCE\ClientiEmployees\Pages\CreateClientiEmployee;
use App\Filament\Resources\COMPILANCE\ClientiEmployees\Pages\EditClientiEmployee;
use App\Filament\Resources\COMPILANCE\ClientiEmployees\Pages\ListClientiEmployees;
use App\Filament\Resources\COMPILANCE\ClientiEmployees\Schemas\ClientiEmployeeForm;
use App\Filament\Resources\COMPILANCE\ClientiEmployees\Tables\ClientiEmployeesTable;
use App\Models\COMPILANCE\ClientiEmployee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientiEmployeeResource extends Resource
{
    protected static ?string $model = ClientiEmployee::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Compliance';

    protected static ?int $navigationSort = 80;

    public static function form(Schema $schema): Schema
    {
        return ClientiEmployeeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientiEmployeesTable::configure($table);
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
            'index' => ListClientiEmployees::route('/'),
            'create' => CreateClientiEmployee::route('/create'),
            'edit' => EditClientiEmployee::route('/{record}/edit'),
        ];
    }
}
