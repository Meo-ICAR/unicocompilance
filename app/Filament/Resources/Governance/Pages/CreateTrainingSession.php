<?php

declare(strict_types=1);

namespace App\Filament\Resources\Governance\Pages;

use App\Filament\Resources\Governance\TrainingSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrainingSession extends CreateRecord
{
    protected static string $resource = TrainingSessionResource::class;
}
