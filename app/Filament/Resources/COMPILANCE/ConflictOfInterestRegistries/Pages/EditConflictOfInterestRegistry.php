<?php

namespace App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Pages;

use App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\ConflictOfInterestRegistryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditConflictOfInterestRegistry extends EditRecord
{
    protected static string $resource = ConflictOfInterestRegistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
