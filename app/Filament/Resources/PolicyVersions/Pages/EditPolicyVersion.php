<?php

namespace App\Filament\Resources\PolicyVersions\Pages;

use App\Filament\Resources\PolicyVersions\PolicyVersionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPolicyVersion extends EditRecord
{
    protected static string $resource = PolicyVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
