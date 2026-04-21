<?php

namespace App\Filament\Resources\DpaProcessingActivities\Pages;

use App\Filament\Resources\DpaProcessingActivities\DpaProcessingActivityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDpaProcessingActivity extends EditRecord
{
    protected static string $resource = DpaProcessingActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
