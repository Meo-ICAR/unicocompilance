<?php

namespace App\Filament\Resources\GdprDataBreaches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use App\Models\GdprDataBreach;
use App\Enums\GdprBreachStatus;

class GdprDataBreachesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_id')
                    ->label('Azienda')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nature_of_breach')
                    ->label('Natura Violazione')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('subjects_affected_count')
                    ->label('Soggetti Coinvolti')
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_notified_to_authority')
                    ->label('Notificata')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'investigating' => 'warning',
                        'contained' => 'info',
                        'closed' => 'success',
                    }),
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'investigating' => 'In Investigazione',
                        'contained' => 'Contenuto',
                        'closed' => 'Chiuso',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('incident_date')
                    ->label('Data Incidente')
                    ->dateTime('d/m/Y'),
                    ->sortable(),
                Tables\Columns\TextColumn::make('discovery_date')
                    ->label('Data Scoperta')
                    ->dateTime('d/m/Y'),
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('nature_of_breach')
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
                Tables\Filters\SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'investigating' => 'In Investigazione',
                        'contained' => 'Contenuto',
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
            ->emptyStateHeading('Nessuna violazione dati trovata')
            ->emptyStateDescription('Registra la tua prima violazione dati GDPR.')
            ->emptyStateIcon('heroicon-o-shield-exclamation')
    }
}
