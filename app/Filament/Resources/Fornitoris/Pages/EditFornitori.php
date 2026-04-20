<?php

namespace App\Filament\Resources\Fornitoris\Pages;

use App\Filament\Resources\Fornitoris\FornitoriResource;
use App\Models\PROFORMA\Fornitori;
// use App\Services\ChecklistService;
// use App\Services\GeminiVisionService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditFornitori extends EditRecord
{
    protected static string $resource = FornitoriResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
