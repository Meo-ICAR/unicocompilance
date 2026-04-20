<?php

namespace App\Filament\Resources\Clientis;

use App\Filament\RelationManagers\DocumentsRelationManager;
use App\Filament\RelationManagers\WebsitesRelationManager;
use App\Filament\Resources\Clientis\Imports\ClientisImport;
use App\Filament\Resources\Clientis\Pages\CreateClienti;
use App\Filament\Resources\Clientis\Pages\EditClienti;
use App\Filament\Resources\Clientis\Pages\ListClientis;
use App\Filament\Resources\Clientis\Pages\ListClientiScopes;
use App\Filament\Resources\Clientis\RelationManagers\ClientiMandatesRelationManager;
use App\Filament\Resources\Clientis\RelationManagers\ClientiScopesRelationManager;
use App\Filament\Resources\Clientis\RelationManagers\ContactsRelationManager;
use App\Filament\Resources\Clientis\RelationManagers\EmployeesRelationManager;
use App\Filament\Resources\Clientis\Schemas\ClientiForm;
use App\Filament\Resources\Clientis\Tables\ClientisTable;
// use App\Filament\Traits\HasChecklistAction;
use App\Models\PROFORMA\Clienti;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;

class ClientiResource extends Resource
{
    protected static ?string $model = Clienti::class;

    // 2. Usa il Trait nella classe della Risorsa

    // use HasChecklistAction;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Anagrafiche';

    protected static ?string $navigationLabel = 'Istituti';

    protected static ?string $modelLabel = 'Istituto';

    protected static ?string $pluralModelLabel = 'Istituti';

    public static function form(Schema $schema): Schema
    {
        return ClientiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ContactsRelationManager::class,
            ClientiMandatesRelationManager::class,
            ClientiScopesRelationManager::class,
            DocumentsRelationManager::class,
            WebsitesRelationManager::class,
            EmployeesRelationManager::class,
            SalesInvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientis::route('/'),
            'scopes' => ListClientiScopes::route('/scopes'),
            'create' => CreateClienti::route('/create'),
            'edit' => EditClienti::route('/{record}/edit'),
        ];
    }
}
