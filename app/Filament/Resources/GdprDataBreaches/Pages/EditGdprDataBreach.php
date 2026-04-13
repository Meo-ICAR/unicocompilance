<?php

namespace App\Filament\Resources\GdprDataBreaches\Pages;

use App\Filament\Resources\GdprDataBreaches\GdprDataBreachResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditGdprDataBreach extends EditRecord
{
    protected static string $resource = GdprDataBreachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
