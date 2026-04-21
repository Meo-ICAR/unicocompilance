<?php

namespace App\Filament\Resources\DpaProcessingActivities\Pages;

use App\Filament\Resources\DpaProcessingActivities\DpaProcessingActivityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDpaProcessingActivities extends ListRecords
{
    protected static string $resource = DpaProcessingActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
