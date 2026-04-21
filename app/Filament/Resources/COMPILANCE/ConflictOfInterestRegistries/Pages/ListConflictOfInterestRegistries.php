<?php

namespace App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Pages;

use App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\ConflictOfInterestRegistryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConflictOfInterestRegistries extends ListRecords
{
    protected static string $resource = ConflictOfInterestRegistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
