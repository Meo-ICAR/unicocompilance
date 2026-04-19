<?php

namespace App\Filament\Resources\GdprDsrRequests\Pages;

use App\Filament\Resources\GdprDsrRequests\GdprDsrRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGdprDsrRequest extends CreateRecord
{
    protected static string $resource = GdprDsrRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = filament()->getTenant()?->id;
        return $data;
    }
}
