<?php

namespace App\Filament\Resources\PolicyAcknowledgments\Pages;

use App\Filament\Resources\PolicyAcknowledgments\PolicyAcknowledgmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPolicyAcknowledgments extends ListRecords
{
    protected static string $resource = PolicyAcknowledgmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
