<?php

namespace App\Filament\Resources\GdprDataBreaches;

use App\Enums\GdprBreachStatus;
use App\Filament\Resources\GdprDataBreaches\Pages\CreateGdprDataBreach;
use App\Filament\Resources\GdprDataBreaches\Pages\EditGdprDataBreach;
use App\Filament\Resources\GdprDataBreaches\Pages\ListGdprDataBreaches;
use App\Filament\Resources\GdprDataBreaches\Schemas\GdprDataBreachForm;
use App\Filament\Resources\GdprDataBreaches\Tables\GdprDataBreachesTable;
use App\Models\COMPILANCE\GdprDataBreach;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BackedEnum;

class GdprDataBreachResource extends Resource
{
    protected static ?string $model = GdprDataBreach::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldExclamation;

    protected static ?string $recordTitleAttribute = 'company_id';

    protected static ?string $label = 'Data Breach GDPR';

    protected static ?string $pluralLabel = 'Data Breach GDPR';

    protected static string|\UnitEnum|null $navigationGroup = 'Privacy & GDPR';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return GdprDataBreachForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GdprDataBreachesTable::configure($table);
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
            'index' => ListGdprDataBreaches::route('/'),
            'create' => CreateGdprDataBreach::route('/create'),
            'edit' => EditGdprDataBreach::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nature_of_breach', 'subjects_affected_count'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'investigating')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
