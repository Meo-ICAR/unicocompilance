<?php

declare(strict_types=1);

namespace App\Filament\Resources\Governance;

use Filament\Clusters\Cluster;
use UnitEnum;
use BackedEnum;

class GovernanceCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Governance';
    protected static string|UnitEnum|null $navigationGroup = 'Formazione';
}
