<?php

namespace App\Filament\Resources\GdprDataBreaches\Pages;

use App\Filament\Resources\GdprDataBreaches\GdprDataBreachResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGdprDataBreach extends CreateRecord
{
    protected static string $resource = GdprDataBreachResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = filament()->getTenant()?->id;
        return $data;
    }
}
