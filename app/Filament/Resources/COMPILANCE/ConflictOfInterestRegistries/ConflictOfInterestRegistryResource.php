<?php

namespace App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries;

use App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Pages\CreateConflictOfInterestRegistry;
use App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Pages\EditConflictOfInterestRegistry;
use App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Pages\ListConflictOfInterestRegistries;
use App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Schemas\ConflictOfInterestRegistryForm;
use App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Tables\ConflictOfInterestRegistriesTable;
use App\Models\COMPILANCE\ConflictOfInterestRegistry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConflictOfInterestRegistryResource extends Resource
{
    protected static ?string $model = ConflictOfInterestRegistry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ConflictOfInterestRegistryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConflictOfInterestRegistriesTable::configure($table);
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
            'index' => ListConflictOfInterestRegistries::route('/'),
            'create' => CreateConflictOfInterestRegistry::route('/create'),
            'edit' => EditConflictOfInterestRegistry::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
