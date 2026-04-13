<?php

/**
 * SCOPO: Definire categorie e stati per GDPR, Reclami e Formazione.
 * PATH: app/Enums/ComplianceEnums.php
 * (Nota: in un progetto reale potresti separarli in file singoli come GdprBreachStatus.php, ecc.)
 */

namespace App\Enums;

enum GdprBreachStatus: string
{
    case INVESTIGATING = 'investigating';
    case CONTAINED = 'contained';
    case CLOSED = 'closed';
}

enum GdprDsrStatus: string
{
    case PENDING = 'pending';
    case EXTENDED = 'extended';
    case FULFILLED = 'fulfilled';
    case REJECTED = 'rejected';
}

enum ComplaintStatus: string
{
    case OPEN = 'open';
    case INVESTIGATING = 'investigating';
    case RESOLVED = 'resolved';
    case REJECTED = 'rejected';
}

enum RegulatoryFramework: string
{
    case IVASS = 'ivass';
    case OAM = 'oam';
    case GDPR = 'gdpr';
    case SAFETY = 'safety';
}
