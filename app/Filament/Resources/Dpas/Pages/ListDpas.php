<?php

namespace App\Filament\Resources\Dpas\Pages;

use App\Filament\Resources\Dpas\DpaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDpas extends ListRecords
{
    protected static string $resource = DpaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
