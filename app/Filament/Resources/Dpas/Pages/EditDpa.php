<?php

namespace App\Filament\Resources\Dpas\Pages;

use App\Filament\Resources\Dpas\DpaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDpa extends EditRecord
{
    protected static string $resource = DpaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
