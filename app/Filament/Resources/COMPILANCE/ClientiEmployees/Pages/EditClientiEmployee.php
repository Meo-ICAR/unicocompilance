<?php

namespace App\Filament\Resources\COMPILANCE\ClientiEmployees\Pages;

use App\Filament\Resources\COMPILANCE\ClientiEmployees\ClientiEmployeeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClientiEmployee extends EditRecord
{
    protected static string $resource = ClientiEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
