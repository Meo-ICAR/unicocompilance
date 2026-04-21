<?php

namespace App\Filament\Resources\COMPILANCE\SuspiciousActivityReports\Pages;

use App\Filament\Resources\COMPILANCE\SuspiciousActivityReports\SuspiciousActivityReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSuspiciousActivityReports extends ListRecords
{
    protected static string $resource = SuspiciousActivityReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
