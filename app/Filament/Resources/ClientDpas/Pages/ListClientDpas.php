<?php

namespace App\Filament\Resources\ClientDpas\Pages;

use App\Filament\Resources\ClientDpas\ClientDpaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientDpas extends ListRecords
{
    protected static string $resource = ClientDpaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
