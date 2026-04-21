<?php

namespace App\Filament\Resources\PolicyAcknowledgments\Pages;

use App\Filament\Resources\PolicyAcknowledgments\PolicyAcknowledgmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPolicyAcknowledgment extends EditRecord
{
    protected static string $resource = PolicyAcknowledgmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
