<?php

namespace App\Filament\Resources\Clientis\Pages;

use App\Filament\Resources\Clientis\ClientiResource;
use App\Services\ChecklistService;
use Filament\Actions\DeleteAction;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditClienti extends EditRecord
{
    protected static string $resource = ClientiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
