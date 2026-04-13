<?php

namespace App\Filament\Resources\GdprDataBreaches\Pages;

use App\Filament\Resources\GdprDataBreaches\GdprDataBreachResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGdprDataBreaches extends ListRecords
{
    protected static string $resource = GdprDataBreachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
