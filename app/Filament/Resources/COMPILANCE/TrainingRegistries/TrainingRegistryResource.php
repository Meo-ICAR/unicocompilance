<?php

namespace App\Filament\Resources\COMPILANCE\TrainingRegistries;

use App\Filament\Resources\COMPILANCE\TrainingRegistries\Pages\CreateTrainingRegistry;
use App\Filament\Resources\COMPILANCE\TrainingRegistries\Pages\EditTrainingRegistry;
use App\Filament\Resources\COMPILANCE\TrainingRegistries\Pages\ListTrainingRegistries;
use App\Filament\Resources\COMPILANCE\TrainingRegistries\Schemas\TrainingRegistryForm;
use App\Filament\Resources\COMPILANCE\TrainingRegistries\Tables\TrainingRegistriesTable;
use App\Models\COMPILANCE\TrainingRegistry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingRegistryResource extends Resource
{
    protected static ?string $model = TrainingRegistry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

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

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingRegistries::route('/'),
            'create' => CreateTrainingRegistry::route('/create'),
            'edit' => EditTrainingRegistry::route('/{record}/edit'),
        ];
    }
}
