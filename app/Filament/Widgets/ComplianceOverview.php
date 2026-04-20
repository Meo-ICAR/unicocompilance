<?php
namespace App\Filament\Widgets;

use App\Enums\AmlReportStatus;
use App\Models\COMPILANCE\AmlSosReport;
use App\Models\COMPILANCE\GdprDsrRequest;
use App\Models\COMPILANCE\TrainingRegistry;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ComplianceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // 1. DSR Privacy in Scadenza (< 5 giorni)
        $urgentDsrs = GdprDsrRequest::where('status', 'pending')
            ->whereDate('due_date', '<=', today()->addDays(5))
            ->count();

        // 2. SOS Antiriciclaggio in attesa di valutazione
        $pendingAml = AmlSosReport::where('status', AmlReportStatus::EVALUATING)->count();

        // 3. Agenti non operativi (Formazione Scaduta)
        $expiredTraining = TrainingRegistry::whereDate('valid_until', '<', today())->count();

        return [
            Stat::make('Urgenze Privacy (DSR)', $urgentDsrs)
                ->description($urgentDsrs > 0 ? 'Pratiche in scadenza nei prossimi 5 gg!' : 'Tutto sotto controllo')
                ->descriptionIcon($urgentDsrs > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-badge')
                ->color($urgentDsrs > 0 ? 'danger' : 'success')
                ->chart([7, 3, 4, 5, 6, 3, $urgentDsrs]),  // Sparkline trend (opzionale)
            Stat::make('SOS Antiriciclaggio', $pendingAml)
                ->description('Segnalazioni in attesa di valutazione')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color($pendingAml > 0 ? 'warning' : 'gray'),
            Stat::make('Allarmi Formazione', $expiredTraining)
                ->description('Agenti con certificati scaduti')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color($expiredTraining > 0 ? 'danger' : 'success'),
        ];
    }
}
