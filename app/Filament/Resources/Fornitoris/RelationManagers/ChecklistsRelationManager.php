<?php

namespace App\Filament\Resources\Fornitoris\RelationManagers;

use App\Filament\RelationManagers\BaseChecklistsRelationManager;

class ChecklistsRelationManager extends BaseChecklistsRelationManager
{
    protected static ?string $title = 'Checklist Fornitore';

    /**
     * Personalizzazione specifica per Fornitori
     */
    protected function getTargetTypeLabel(): string
    {
        return 'Fornitore';
    }
}
