<?php

namespace App\Filament\Resources\Fornitoris;

use App\Filament\RelationManagers\ChecklistsRelationManager;
use App\Filament\RelationManagers\DocumentsRelationManager;
use App\Filament\RelationManagers\TrainingSessionsRelationManager;
use App\Filament\RelationManagers\WebsitesRelationManager;
use App\Filament\Resources\Fornitoris\Pages\CreateFornitori;
use App\Filament\Resources\Fornitoris\Pages\EditFornitori;
use App\Filament\Resources\Fornitoris\Pages\ListFornitoris;
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

    protected static string|UnitEnum|null $navigationGroup = 'Anagrafiche';

    protected static ?string $navigationLabel = 'Agenti';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Agente';

    protected static ?string $pluralModelLabel = 'Agenti';

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
            TrainingSessionsRelationManager::class,
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
