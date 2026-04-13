<?php
namespace App\Filament\Widgets;

use App\Enums\AmlReportStatus;
use App\Enums\GdprDsrStatus;
use App\Models\AmlSosReport;
use App\Models\GdprDsrRequest;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ComplianceStatsOverview extends BaseWidget
{
    // Aggiorna i dati ogni 60 secondi in background
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        // 1. DSR Privacy in Scadenza (< 5 giorni)
        $urgentDsrs = GdprDsrRequest::where('status', GdprDsrStatus::PENDING)
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
