<?php

namespace App\Filament\Resources\PolicyVersions;

use App\Filament\Resources\PolicyVersions\Pages\CreatePolicyVersion;
use App\Filament\Resources\PolicyVersions\Pages\EditPolicyVersion;
use App\Filament\Resources\PolicyVersions\Pages\ListPolicyVersions;
use App\Filament\Resources\PolicyVersions\Schemas\PolicyVersionForm;
use App\Filament\Resources\PolicyVersions\Tables\PolicyVersionsTable;
use App\Models\COMPILANCE\PolicyVersion;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class PolicyVersionResource extends Resource
{
    protected static ?string $model = PolicyVersion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Privacy & GDPR';

    protected static ?int $navigationSort = 85;

    public static function form(Schema $schema): Schema
    {
        return PolicyVersionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PolicyVersionsTable::configure($table);
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
            'index' => ListPolicyVersions::route('/'),
            'create' => CreatePolicyVersion::route('/create'),
            'edit' => EditPolicyVersion::route('/{record}/edit'),
        ];
    }
}
