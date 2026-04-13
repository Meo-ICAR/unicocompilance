<?php

namespace App\Filament\Resources\AmlSosReports\Tables;

use App\Enums\AmlReportStatus;
use App\Models\AmlSosReport;
use App\Services\UnicoDocService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;

class AmlSosReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                // Utilizza la relazione logica BelongsTo configurata sul Model
                Tables\Columns\TextColumn::make('agent.name')
                    ->label('Agente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('practice_reference')
                    ->label('Rif. Pratica BPM')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn(AmlReportStatus $state): string => match ($state) {
                        AmlReportStatus::DRAFTED => 'gray',
                        AmlReportStatus::EVALUATING => 'warning',
                        AmlReportStatus::REPORTED => 'danger',
                        AmlReportStatus::ARCHIVED => 'success',
                    })
                    ->formatStateUsing(fn(AmlReportStatus $state): string => $state->label()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Action custom per l'integrazione con UnicoDoc
                Tables\Actions\Action::make('allega_ricevuta_uif')
                    ->label('Allega Ricevuta UIF')
                    ->icon('heroicon-o-document-arrow-up')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\FileUpload::make('receipt')
                            ->label('File Ricevuta')
                            ->required(),
                    ])
                    ->action(function (AmlSosReport $record, array $data, UnicoDocService $unicoDocService) {
                        // Richiama il servizio di integrazione
                        $unicoDocService->storeFiuReceipt($record, $data['receipt'], auth()->id());
                    })
                    ->visible(fn(AmlSosReport $record) => $record->status === AmlReportStatus::EVALUATING),
            ]);
    }
}
