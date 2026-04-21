<?php

namespace App\Filament\Resources\DpiaRisks;

use App\Filament\Resources\DpiaRisks\Pages\CreateDpiaRisk;
use App\Filament\Resources\DpiaRisks\Pages\EditDpiaRisk;
use App\Filament\Resources\DpiaRisks\Pages\ListDpiaRisks;
use App\Filament\Resources\DpiaRisks\Schemas\DpiaRiskForm;
use App\Filament\Resources\DpiaRisks\Tables\DpiaRisksTable;
use App\Models\COMPILANCE\DpiaRisk;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class DpiaRiskResource extends Resource
{
    protected static ?string $model = DpiaRisk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Privacy & GDPR';

    protected static ?int $navigationSort = 55;

    protected static bool $isScopedToTenant = false;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DpiaRiskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DpiaRisksTable::configure($table);
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
            'index' => ListDpiaRisks::route('/'),
            'create' => CreateDpiaRisk::route('/create'),
            'edit' => EditDpiaRisk::route('/{record}/edit'),
        ];
    }
}
