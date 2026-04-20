<?php

namespace App\Filament\Resources\Clientis\Pages;

use App\Filament\Resources\Clientis\ClientiResource;
// use App\Filament\Traits\HasRegolamentoAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientiScopes extends ListRecords
{
    // use HasRegolamentoAction;

    protected static string $resource = ClientiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            //  $this->getRegolamentoAction(),
        ];
    }
}
