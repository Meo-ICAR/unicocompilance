<?php

namespace App\Filament\Resources\AmlSosReports\Pages;

use App\Filament\Resources\AmlSosReports\AmlSosReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAmlSosReport extends CreateRecord
{
    protected static string $resource = AmlSosReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = filament()->getTenant()?->id;
        return $data;
    }
}
