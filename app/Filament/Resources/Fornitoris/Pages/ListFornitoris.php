<?php

namespace App\Filament\Resources\Fornitoris\Pages;

use App\Filament\Resources\Fornitoris\FornitoriResource;
// use App\Filament\Traits\HasChecklistAction;  // 1. Importa il namespace
// use App\Filament\Traits\HasRegolamentoAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFornitoris extends ListRecords
{
    // use HasRegolamentoAction;

    protected static string $resource = FornitoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            // $this->getRegolamentoAction(),
        ];
    }
}
