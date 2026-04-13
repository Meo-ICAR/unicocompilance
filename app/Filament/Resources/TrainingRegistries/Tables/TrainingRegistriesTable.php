<?php

namespace App\Filament\Resources\TrainingRegistries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use App\Models\TrainingRegistry;
use App\Enums\RegulatoryFramework;

class TrainingRegistriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Agente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course_name')
                    ->label('Nome Corso')
                    ->searchable()
                    ->limit(80),
                Tables\Columns\TextColumn::make('regulatory_framework')
                    ->label('Quadro Normativo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ivass' => 'primary',
                        'oam' => 'warning',
                        'gdpr' => 'danger',
                        'safety' => 'success',
                        'aml' => 'info',
                        'privacy' => 'secondary',
                        'risk' => 'warning',
                        'compliance' => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ivass' => 'IVASS',
                        'oam' => 'OAM',
                        'gdpr' => 'GDPR',
                        'safety' => 'Sicurezza',
                        'aml' => 'Antiriciclaggio',
                        'privacy' => 'Privacy',
                        'risk' => 'Rischio',
                        'compliance' => 'Compliance',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Data Completamento')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Valido Fino al')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record): string => $record->valid_until && $record->valid_until->isPast() ? 'danger' : 'success'),
                Tables\Columns\IconColumn::make('certificate_document_id')
                    ->label('Certificato')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('regulatory_framework')
                    ->label('Quadro Normativo')
                    ->options([
                        'ivass' => 'IVASS',
                        'oam' => 'OAM',
                        'gdpr' => 'GDPR',
                        'safety' => 'Sicurezza',
                        'aml' => 'Antiriciclaggio',
                        'privacy' => 'Privacy',
                        'risk' => 'Rischio',
                        'compliance' => 'Compliance',
                    ]),
                Tables\Filters\Filter::make('expired')
                    ->label('Solo Scaduti')
                    ->query(fn ($query): Builder => $query->where('valid_until', '<', now())),
                Tables\Filters\Filter::make('certified')
                    ->label('Con Certificato')
                    ->query(fn ($query): Builder => $query->whereNotNull('certificate_document_id')),
            ])
            ->recordActions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Nessun corso di formazione trovato')
            ->emptyStateDescription('Registra il tuo primo corso di formazione.')
            ->emptyStateIcon('heroicon-o-academic-cap')
    }
}
