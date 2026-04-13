<?php

/**
 * SCOPO: Definire gli stati immutabili per le Segnalazioni Operazioni Sospette (AML).
 * PATH: app/Enums/AmlReportStatus.php
 * CONSTRAINT: Utilizzo di Enum nativi PHP 8.4 per type safety e integrazione con Filament.
 */

namespace App\Enums;

enum AmlReportStatus: string
{
    case DRAFTED = 'drafted';
    case EVALUATING = 'evaluating';
    case REPORTED = 'reported';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFTED => 'Bozza',
            self::EVALUATING => 'In Valutazione',
            self::REPORTED => 'Segnalata UIF',
            self::ARCHIVED => 'Archiviata',
        };
    }
}
