<?php

namespace App\Filament\Resources\AmlSosReports\Pages;

use App\Filament\Resources\AmlSosReports\AmlSosReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAmlSosReport extends EditRecord
{
    protected static string $resource = AmlSosReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
