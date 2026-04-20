<?php

/**
 * SCOPO: Tabella incorporata nella Dashboard per agire sulle 5 pratiche DSR più urgenti.
 * PATH: app/Filament/Widgets/UrgentDsrTableWidget.php
 */

namespace App\Filament\Widgets;

use App\Filament\Resources\GdprDsrRequests\GdprDsrRequestResource;
use App\Models\COMPILANCE\GdprDsrRequest;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;

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
                    ->where('status', 'pending')
                    ->orderBy('due_date', 'asc')
                    ->limit(5)
            )
            ->heading('🔥 Pratiche Privacy ad Alta Priorità')
            ->description('Richieste DSR che richiedono azione immediata per evitare sanzioni.')
            ->columns([
                TextColumn::make('subject_name')->label('Soggetto'),
                TextColumn::make('request_type')
                    ->label('Tipo')
                    ->badge(),
                TextColumn::make('due_date')
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
                    ->url(fn(GdprDsrRequest $record): string => GdprDsrRequestResource::getUrl('edit', ['record' => $record]))
            ])
            ->paginated(false);  // Niente paginazione, è una top 5
    }
}
