<?php

namespace App\Filament\Resources\Fornitoris;

use App\Filament\RelationManagers\DocumentsRelationManager;
use App\Filament\RelationManagers\WebsitesRelationManager;
use App\Filament\Resources\Fornitoris\Pages\CreateFornitori;
use App\Filament\Resources\Fornitoris\Pages\EditFornitori;
use App\Filament\Resources\Fornitoris\Pages\ListFornitoris;
use App\Filament\Resources\Fornitoris\RelationManagers\ChecklistsRelationManager;
use App\Filament\Resources\Fornitoris\RelationManagers\TrainingRecordsRelationManager;
use App\Filament\Resources\Fornitoris\Schemas\FornitoriForm;
use App\Filament\Resources\Fornitoris\Tables\FornitorisTable;
use App\Models\PROFORMA\Fornitori;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;

class FornitoriResource extends Resource
{
    protected static ?string $model = Fornitori::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|UnitEnum|null $navigationGroup = 'Organizzazione';

    protected static ?string $navigationLabel = 'Fornitori';

    protected static ?string $modelLabel = 'Fornitore';

    protected static ?string $pluralModelLabel = 'Fornitori';

    public static function form(Schema $schema): Schema
    {
        return FornitoriForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FornitorisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DocumentsRelationManager::class,
            WebsitesRelationManager::class,
            ChecklistsRelationManager::class,
            TrainingRecordsRelationManager::class,
            PurchaseInvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFornitoris::route('/'),
            'create' => CreateFornitori::route('/create'),
            'edit' => EditFornitori::route('/{record}/edit'),
        ];
    }
}
