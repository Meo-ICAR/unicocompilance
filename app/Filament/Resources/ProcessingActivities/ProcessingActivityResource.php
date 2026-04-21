<?php

namespace App\Filament\Resources\ProcessingActivities;

use App\Filament\Resources\ProcessingActivities\Pages\CreateProcessingActivity;
use App\Filament\Resources\ProcessingActivities\Pages\EditProcessingActivity;
use App\Filament\Resources\ProcessingActivities\Pages\ListProcessingActivities;
use App\Filament\Resources\ProcessingActivities\Schemas\ProcessingActivityForm;
use App\Filament\Resources\ProcessingActivities\Tables\ProcessingActivitiesTable;
use App\Models\COMPILANCE\ProcessingActivity;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class ProcessingActivityResource extends Resource
{
    protected static ?string $model = ProcessingActivity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Privacy & GDPR';

    protected static ?int $navigationSort = 60;

    public static function form(Schema $schema): Schema
    {
        return ProcessingActivityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcessingActivitiesTable::configure($table);
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
            'index' => ListProcessingActivities::route('/'),
            'create' => CreateProcessingActivity::route('/create'),
            'edit' => EditProcessingActivity::route('/{record}/edit'),
        ];
    }
}
