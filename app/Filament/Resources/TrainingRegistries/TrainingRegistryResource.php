<?php

namespace App\Filament\Resources\TrainingRegistries;

use App\Enums\RegulatoryFramework;
use App\Filament\Resources\TrainingRegistries\Pages\CreateTrainingRegistry;
use App\Filament\Resources\TrainingRegistries\Pages\EditTrainingRegistry;
use App\Filament\Resources\TrainingRegistries\Pages\ListTrainingRegistries;
use App\Filament\Resources\TrainingRegistries\Schemas\TrainingRegistryForm;
use App\Filament\Resources\TrainingRegistries\Tables\TrainingRegistriesTable;
use App\Models\TrainingRegistry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;

class TrainingRegistryResource extends Resource
{
    protected static ?string $model = TrainingRegistry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'course_name';

    protected static ?string $label = 'Registro Formazione';

    protected static ?string $pluralLabel = 'Registro Formazione';

    protected static ?string $navigationGroup = 'Compliance';

    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return TrainingRegistryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingRegistriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user'])  // Preload relationship
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['course_name', 'regulatory_framework'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('valid_until', '<', now())->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
