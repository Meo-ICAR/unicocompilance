<?php

namespace App\Filament\Resources\COMPILANCE\TrainingRegistries\Pages;

use App\Filament\Resources\COMPILANCE\TrainingRegistries\TrainingRegistryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingRegistry extends EditRecord
{
    protected static string $resource = TrainingRegistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
