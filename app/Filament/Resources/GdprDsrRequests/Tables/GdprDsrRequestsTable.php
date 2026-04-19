<?php

namespace App\Filament\Resources\GdprDsrRequests\Tables;

use App\Models\GdprDsrRequest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class GdprDsrRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('received_at')
                    ->label('Data Ricezione')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('subject_name')
                    ->label('Nome Soggetto')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('request_type')
                    ->label('Tipo Richiesta')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'access' => 'primary',
                        'rectification' => 'warning',
                        'erasure' => 'danger',
                        'portability' => 'info',
                        'restriction' => 'secondary',
                        'objection' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'access' => 'Accesso ai Dati',
                        'rectification' => 'Rettifica Dati',
                        'erasure' => 'Cancellazione Dati',
                        'portability' => 'Portabilità Dati',
                        'restriction' => 'Limitazione Trattamento',
                        'objection' => 'Opposizione al Trattamento',
                        default => $state,
                    }),

                TextColumn::make('due_date')
                    ->label('Data Scadenza')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->color(fn($record): string => $record->due_date->isPast() ? 'danger' : 'default'),
                IconColumn::make('unicodoc_request_id')
                    ->label('Rif. UnicoDoc')
                    ->boolean()
                    ->trueIcon('heroicon-o-link')
                    ->falseIcon('heroicon-o-x-mark'),
                TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'extended' => 'info',
                        'fulfilled' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'In Attesa',
                        'extended' => 'Esteso',
                        'fulfilled' => 'Evaso',
                        'rejected' => 'Rifiutato',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('request_type')
                    ->label('Tipo Richiesta')
                    ->options([
                        'access' => 'Accesso ai Dati',
                        'rectification' => 'Rettifica Dati',
                        'erasure' => 'Cancellazione Dati',
                        'portability' => 'Portabilità Dati',
                        'restriction' => 'Limitazione Trattamento',
                        'objection' => 'Opposizione al Trattamento',
                    ]),
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'pending' => 'In Attesa',
                        'extended' => 'Esteso',
                        'fulfilled' => 'Evaso',
                        'rejected' => 'Rifiutato',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
           //     DeleteAction::make(),
           //     RestoreAction::make(),
            //    ForceDeleteAction::make(),
            ])
            ->toolbarActions([

            ])
            ->emptyStateHeading('Nessuna richiesta DSR trovata')
            ->emptyStateDescription('Crea la tua prima richiesta DSR.')
            ->emptyStateIcon('heroicon-o-document-text');
    }
}
