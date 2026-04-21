<?php

namespace App\Filament\Resources\GdprDsrRequests;

use App\Filament\Resources\GdprDsrRequests\Pages\CreateGdprDsrRequest;
use App\Filament\Resources\GdprDsrRequests\Pages\EditGdprDsrRequest;
use App\Filament\Resources\GdprDsrRequests\Pages\ListGdprDsrRequests;
use App\Filament\Resources\GdprDsrRequests\Schemas\GdprDsrRequestForm;
use App\Filament\Resources\GdprDsrRequests\Tables\GdprDsrRequestsTable;
use App\Models\COMPILANCE\GdprDsrRequest;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BackedEnum;

class GdprDsrRequestResource extends Resource
{
    protected static ?string $model = GdprDsrRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'subject_name';

    protected static ?string $label = 'Richieste Privacy';

    protected static ?string $pluralLabel = 'Richieste Privacy';

    protected static string|\UnitEnum|null $navigationGroup = 'Privacy & GDPR';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return GdprDsrRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GdprDsrRequestsTable::configure($table);
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
            'index' => ListGdprDsrRequests::route('/'),
            'create' => CreateGdprDsrRequest::route('/create'),
            'edit' => EditGdprDsrRequest::route('/{record}/edit'),
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
        return ['subject_name', 'request_type', 'due_date'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
