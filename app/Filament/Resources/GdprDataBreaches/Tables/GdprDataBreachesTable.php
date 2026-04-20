<?php

namespace App\Filament\Resources\GdprDataBreaches\Tables;

use App\Enums\GdprBreachStatus;
use App\Models\COMPILANCE\GdprDataBreach;
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

class GdprDataBreachesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nome'),
                TextColumn::make('nature_of_breach')
                    ->label('Natura Violazione')
                    ->badge()
                    ->color('warning'),
                TextColumn::make('subjects_affected_count')
                    ->label('Soggetti Coinvolti')
                    ->alignCenter(),
                IconColumn::make('is_notified_to_authority')
                    ->label('Notificata')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'investigating' => 'warning',
                        'contained' => 'info',
                        'closed' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'investigating' => 'In Investigazione',
                        'contained' => 'Contenuto',
                        'closed' => 'Chiuso',
                        default => $state,
                    }),
                TextColumn::make('incident_date')
                    ->label('Data Incidente')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('discovery_date')
                    ->label('Data Scoperta')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('nature_of_breach')
                    ->label('Natura Violazione')
                    ->options([
                        'unauthorized_access' => 'Accesso Non Autorizzato',
                        'data_loss' => 'Perdita Dati',
                        'ransomware' => 'Ransomware',
                        'phishing' => 'Phishing',
                        'malware' => 'Malware',
                        'physical_theft' => 'Furto Fisico',
                        'human_error' => 'Errore Umano',
                        'other' => 'Altro',
                    ]),
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'investigating' => 'In Investigazione',
                        'contained' => 'Contenuto',
                        'closed' => 'Chiuso',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Nessuna violazione dati trovata')
            ->emptyStateDescription('Registra la tua prima violazione dati GDPR.')
            ->emptyStateIcon('heroicon-o-shield-exclamation');
    }
}
