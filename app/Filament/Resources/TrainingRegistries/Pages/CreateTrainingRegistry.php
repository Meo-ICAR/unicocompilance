<?php

namespace App\Filament\Resources\TrainingRegistries\Pages;

use App\Filament\Resources\TrainingRegistries\TrainingRegistryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrainingRegistry extends CreateRecord
{
    protected static string $resource = TrainingRegistryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = filament()->getTenant()?->id;
        return $data;
    }
}
