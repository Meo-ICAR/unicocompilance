<?php

namespace App\Filament\Resources\DpaProcessingActivities;

use App\Filament\Resources\DpaProcessingActivities\Pages\CreateDpaProcessingActivity;
use App\Filament\Resources\DpaProcessingActivities\Pages\EditDpaProcessingActivity;
use App\Filament\Resources\DpaProcessingActivities\Pages\ListDpaProcessingActivities;
use App\Filament\Resources\DpaProcessingActivities\Schemas\DpaProcessingActivityForm;
use App\Filament\Resources\DpaProcessingActivities\Tables\DpaProcessingActivitiesTable;
use App\Models\COMPILANCE\DpaProcessingActivity;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class DpaProcessingActivityResource extends Resource
{
    protected static ?string $model = DpaProcessingActivity::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DpaProcessingActivityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DpaProcessingActivitiesTable::configure($table);
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
            'index' => ListDpaProcessingActivities::route('/'),
            'create' => CreateDpaProcessingActivity::route('/create'),
            'edit' => EditDpaProcessingActivity::route('/{record}/edit'),
        ];
    }
}
