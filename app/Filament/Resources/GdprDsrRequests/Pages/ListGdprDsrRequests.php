<?php

namespace App\Filament\Resources\GdprDsrRequests\Pages;

use App\Filament\Resources\GdprDsrRequests\GdprDsrRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGdprDsrRequests extends ListRecords
{
    protected static string $resource = GdprDsrRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
