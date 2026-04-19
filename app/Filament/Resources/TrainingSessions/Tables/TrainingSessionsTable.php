<?php

namespace App\Filament\Resources\TrainingSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TrainingSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('course_name')
                    ->label('Nome Corso')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('provider')
                    ->label('Ente Erogatore')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('—'),
                TextColumn::make('hours')
                    ->label('Ore')
                    ->numeric()
                    ->sortable()
                    ->suffix(' h'),
                TextColumn::make('trainee_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'App\\Models\\Agent'    => 'Agente',
                        'App\\Models\\Employee' => 'Dipendente',
                        default                 => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'App\\Models\\Agent'    => 'info',
                        'App\\Models\\Employee' => 'success',
                        default                 => 'gray',
                    }),
                TextColumn::make('completion_date')
                    ->label('Data Completamento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('expiry_date')
                    ->label('Scadenza')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('Nessuna')
                    ->color(fn ($record): string => $record->expiry_date && $record->expiry_date->isPast() ? 'danger' : 'success'),
                IconColumn::make('certificate_path')
                    ->label('Certificato')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('trainee_type')
                    ->label('Tipo Partecipante')
                    ->options([
                        'App\\Models\\Agent'    => 'Consulente / Agente',
                        'App\\Models\\Employee' => 'Dipendente / Backoffice',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Nessuna sessione di formazione trovata')
            ->emptyStateDescription('Registra la prima sessione di formazione.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}
