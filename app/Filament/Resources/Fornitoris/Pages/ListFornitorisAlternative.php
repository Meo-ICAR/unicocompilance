<?php

namespace App\Filament\Resources\Fornitoris\Pages;

use App\Filament\Resources\Fornitoris\FornitoriAlternativeResource;
use App\Filament\Traits\HasRegolamentoAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFornitorisAlternative extends ListRecords
{
    use HasRegolamentoAction;

    protected static string $resource = FornitoriAlternativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            $this->getRegolamentoAction(),
        ];
    }
}
