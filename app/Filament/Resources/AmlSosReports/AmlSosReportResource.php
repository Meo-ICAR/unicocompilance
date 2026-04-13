<?php

namespace App\Filament\Resources\AmlSosReports;

use App\Enums\AmlReportStatus;
use App\Filament\Resources\AmlSosReports\Pages\CreateAmlSosReport;
use App\Filament\Resources\AmlSosReports\Pages\EditAmlSosReport;
use App\Filament\Resources\AmlSosReports\Pages\ListAmlSosReports;
use App\Filament\Resources\AmlSosReports\Schemas\AmlSosReportForm;
use App\Filament\Resources\AmlSosReports\Tables\AmlSosReportsTable;
use App\Models\AmlSosReport;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BackedEnum;

class AmlSosReportResource extends Resource
{
    protected static ?string $model = AmlSosReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'practice_reference';

    protected static ?string $label = 'Segnalazioni AML';

    protected static ?string $pluralLabel = 'Segnalazioni AML';

    //  protected static ?string $navigationGroup = 'Compliance';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return AmlSosReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AmlSosReportsTable::configure($table);
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
            'index' => ListAmlSosReports::route('/'),
            'create' => CreateAmlSosReport::route('/create'),
            'edit' => EditAmlSosReport::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['agent'])  // Preload relazione con agente
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['agent']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['practice_reference', 'fiu_protocol_number', 'agent.name'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', AmlReportStatus::EVALUATING)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
