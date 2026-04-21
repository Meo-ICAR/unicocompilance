<?php

namespace App\Filament\Resources\COMPILANCE\ClientiEmployees\Pages;

use App\Filament\Resources\COMPILANCE\ClientiEmployees\ClientiEmployeeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientiEmployees extends ListRecords
{
    protected static string $resource = ClientiEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
