<?php

namespace App\Filament\Resources\ClientDpas\Pages;

use App\Filament\Resources\ClientDpas\ClientDpaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClientDpa extends EditRecord
{
    protected static string $resource = ClientDpaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
