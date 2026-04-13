<?php

namespace App\Filament\Resources\GdprDsrRequests\Pages;

use App\Filament\Resources\GdprDsrRequests\GdprDsrRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditGdprDsrRequest extends EditRecord
{
    protected static string $resource = GdprDsrRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
