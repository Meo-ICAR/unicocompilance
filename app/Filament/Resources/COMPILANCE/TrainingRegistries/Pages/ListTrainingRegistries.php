<?php

namespace App\Filament\Resources\COMPILANCE\TrainingRegistries\Pages;

use App\Filament\Resources\COMPILANCE\TrainingRegistries\TrainingRegistryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingRegistries extends ListRecords
{
    protected static string $resource = TrainingRegistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
