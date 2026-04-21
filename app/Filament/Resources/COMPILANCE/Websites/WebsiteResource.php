<?php

namespace App\Filament\Resources\COMPILANCE\Websites;

use App\Filament\Resources\COMPILANCE\Websites\Pages\CreateWebsite;
use App\Filament\Resources\COMPILANCE\Websites\Pages\EditWebsite;
use App\Filament\Resources\COMPILANCE\Websites\Pages\ListWebsites;
use App\Filament\Resources\COMPILANCE\Websites\Schemas\WebsiteForm;
use App\Filament\Resources\COMPILANCE\Websites\Tables\WebsitesTable;
use App\Models\COMPILANCE\Website;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebsiteResource extends Resource
{
    protected static ?string $model = Website::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Compliance';

    protected static ?int $navigationSort = 75;

    public static function form(Schema $schema): Schema
    {
        return WebsiteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WebsitesTable::configure($table);
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
            'index' => ListWebsites::route('/'),
            'create' => CreateWebsite::route('/create'),
            'edit' => EditWebsite::route('/{record}/edit'),
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
