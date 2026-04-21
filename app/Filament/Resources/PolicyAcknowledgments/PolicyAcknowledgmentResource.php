<?php

namespace App\Filament\Resources\PolicyAcknowledgments;

use App\Filament\Resources\PolicyAcknowledgments\Pages\CreatePolicyAcknowledgment;
use App\Filament\Resources\PolicyAcknowledgments\Pages\EditPolicyAcknowledgment;
use App\Filament\Resources\PolicyAcknowledgments\Pages\ListPolicyAcknowledgments;
use App\Filament\Resources\PolicyAcknowledgments\Schemas\PolicyAcknowledgmentForm;
use App\Filament\Resources\PolicyAcknowledgments\Tables\PolicyAcknowledgmentsTable;
use App\Models\COMPILANCE\PolicyAcknowledgment;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class PolicyAcknowledgmentResource extends Resource
{
    protected static ?string $model = PolicyAcknowledgment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Privacy & GDPR';

    protected static ?int $navigationSort = 90;

    public static function form(Schema $schema): Schema
    {
        return PolicyAcknowledgmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PolicyAcknowledgmentsTable::configure($table);
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
            'index' => ListPolicyAcknowledgments::route('/'),
            'create' => CreatePolicyAcknowledgment::route('/create'),
            'edit' => EditPolicyAcknowledgment::route('/{record}/edit'),
        ];
    }
}
