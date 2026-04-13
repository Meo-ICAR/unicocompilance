<?php

namespace App\Filament\Resources\GdprDsrRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use App\Models\GdprDsrRequest;
use App\Enums\GdprDsrStatus;

class GdprDsrRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject_name')
                    ->label('Nome Soggetto')
                    ->searchable()
                    ->limit(60),
                Tables\Columns\TextColumn::make('request_type')
                    ->label('Tipo Richiesta')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'access' => 'primary',
                        'rectification' => 'warning',
                        'erasure' => 'danger',
                        'portability' => 'info',
                        'restriction' => 'secondary',
                        'objection' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'access' => 'Accesso ai Dati',
                        'rectification' => 'Rettifica Dati',
                        'erasure' => 'Cancellazione Dati',
                        'portability' => 'Portabilità Dati',
                        'restriction' => 'Limitazione Trattamento',
                        'objection' => 'Opposizione al Trattamento',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('received_at')
                    ->label('Data Ricezione')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Data Scadenza')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->color(fn ($record): string => $record->due_date->isPast() ? 'danger' : 'default'),
                Tables\Columns\IconColumn::make('unicodoc_request_id')
                    ->label('Rif. UnicoDoc')
                    ->boolean()
                    ->trueIcon('heroicon-o-link')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'extended' => 'info',
                        'fulfilled' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'In Attesa',
                        'extended' => 'Esteso',
                        'fulfilled' => 'Evaso',
                        'rejected' => 'Rifiutato',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('request_type')
                    ->label('Tipo Richiesta')
                    ->options([
                        'access' => 'Accesso ai Dati',
                        'rectification' => 'Rettifica Dati',
                        'erasure' => 'Cancellazione Dati',
                        'portability' => 'Portabilità Dati',
                        'restriction' => 'Limitazione Trattamento',
                        'objection' => 'Opposizione al Trattamento',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'pending' => 'In Attesa',
                        'extended' => 'Esteso',
                        'fulfilled' => 'Evaso',
                        'rejected' => 'Rifiutato',
                    ]),
            ])
            ->recordActions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Nessuna richiesta DSR trovata')
            ->emptyStateDescription('Crea la tua prima richiesta DSR.')
            ->emptyStateIcon('heroicon-o-document-text');
    }
}
