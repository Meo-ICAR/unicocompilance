<?php

namespace App\Filament\Resources\AmlSosReports\Pages;

use App\Filament\Resources\AmlSosReports\AmlSosReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAmlSosReports extends ListRecords
{
    protected static string $resource = AmlSosReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
