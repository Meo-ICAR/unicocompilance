<?php

namespace App\Filament\Resources\Employees;

use App\Filament\RelationManagers\DocumentsRelationManager;
use App\Filament\RelationManagers\TrainingSessionsRelationManager;
use App\Filament\Resources\Employees\Pages\CreateEmployee;
use App\Filament\Resources\Employees\Pages\EditEmployee;
use App\Filament\Resources\Employees\Pages\ListEmployees;
use App\Filament\Resources\Employees\Schemas\EmployeeForm;
use App\Filament\Resources\Employees\Tables\EmployeesTable;
use App\Models\BPM\Employee;
use App\Models\COMPILANCE\CompanyBranch;
use App\Models\PROFORMA\Company;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $navigationLabel = 'Dipendenti';

    protected static ?string $modelLabel = 'Dipendente';

    protected static ?string $pluralModelLabel = 'Dipendenti';

    protected static ?int $navigationSort = 3;

    protected static string|UnitEnum|null $navigationGroup = 'Organigramma';

    public static function form(Schema $schema): Schema
    {
        return EmployeeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TrainingRecordsRelationManager::class,
            DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployees::route('/'),
            'create' => CreateEmployee::route('/create'),
            'edit' => EditEmployee::route('/{record}/edit'),
        ];
    }
}
