<?php

/**
 * SCOPO: Tabella incorporata nella Dashboard per agire sulle 5 pratiche DSR più urgenti.
 * PATH: app/Filament/Widgets/UrgentDsrTableWidget.php
 */

namespace App\Filament\Widgets;

use App\Actions\Action;
use App\Enums\GdprDsrStatus;
use App\Models\GdprDsrRequest;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class UrgentDsrTableWidget extends BaseWidget
{
    protected static ?int $sort = 2;  // Posiziona sotto i KPI
    protected int|string|array $columnSpan = 'full';  // Occupa tutta la larghezza

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Query: Solo PENDING, ordinate per scadenza più vicina, limite 5
                GdprDsrRequest::query()
                    ->with('company')  // Eager load Proxy Model
                    ->where('status', GdprDsrStatus::PENDING)
                    ->orderBy('due_date', 'asc')
                    ->limit(5)
            )
            ->heading('🔥 Pratiche Privacy ad Alta Priorità')
            ->description('Richieste DSR che richiedono azione immediata per evitare sanzioni.')
            ->columns([
                Tables\Columns\TextColumn::make('company.name')->label('Azienda'),
                Tables\Columns\TextColumn::make('subject_name')->label('Soggetto'),
                Tables\Columns\TextColumn::make('request_type')
                    ->label('Tipo')
                    ->badge(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Scadenza')
                    ->dateTime('d/m/Y')
                    ->color('danger')
                    ->weight('bold'),
            ])
            ->actions([
                // Azione rapida direttamente dalla dashboard
                Action::make('gestisci')
                    ->label('Gestisci')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->url(fn(GdprDsrRequest $record): string => route('filament.admin.resources.gdpr-dsr-requests.edit', $record))
            ])
            ->paginated(false);  // Niente paginazione, è una top 5
    }
}
