<?php

namespace App\Filament\Resources\ComplaintRegistries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use App\Models\ComplaintRegistry;
use App\Enums\ComplaintStatus;

class ComplaintRegistriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('complaint_number')
                    ->label('Numero Reclamo')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Numero reclamo copiato!')
                    ->copyableWithShortcuts(),
                Tables\Columns\TextColumn::make('complainant_name')
                    ->label('Nome Richiedente')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'delay' => 'warning',
                        'behavior' => 'info',
                        'privacy' => 'danger',
                        'fraud' => 'danger',
                        'quality' => 'primary',
                        'contract' => 'secondary',
                        'other' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'delay' => 'Ritardo',
                        'behavior' => 'Comportamento',
                        'privacy' => 'Privacy',
                        'fraud' => 'Frode',
                        'quality' => 'Qualità',
                        'contract' => 'Contrattuale',
                        'other' => 'Altro',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrizione')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),
                Tables\Columns\TextColumn::make('financial_impact')
                    ->label('Impatto Finanziario')
                    ->money('EUR')
                    ->alignEnd(),
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'danger',
                        'investigating' => 'warning',
                        'resolved' => 'success',
                        'rejected' => 'danger',
                        'closed' => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open' => 'Aperto',
                        'investigating' => 'In Investigazione',
                        'resolved' => 'Risolto',
                        'rejected' => 'Rifiutato',
                        'closed' => 'Chiuso',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options([
                        'delay' => 'Ritardo',
                        'behavior' => 'Comportamento',
                        'privacy' => 'Privacy',
                        'fraud' => 'Frode',
                        'quality' => 'Qualità',
                        'contract' => 'Contrattuale',
                        'other' => 'Altro',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'open' => 'Aperto',
                        'investigating' => 'In Investigazione',
                        'resolved' => 'Risolto',
                        'rejected' => 'Rifiutato',
                        'closed' => 'Chiuso',
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
            ->emptyStateHeading('Nessun reclamo trovato')
            ->emptyStateDescription('Crea il tuo primo reclamo.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right')
    }
}
