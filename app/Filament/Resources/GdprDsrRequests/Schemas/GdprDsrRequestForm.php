<?php

namespace App\Filament\Resources\GdprDsrRequests\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components;
use App\Enums\GdprDsrStatus;

class GdprDsrRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('informazioni_richiesta')
                    ->label('Informazioni Richiesta')
                    ->description('Dettagli della richiesta DSR (Data Subject Request)')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\TextInput::make('company_id')
                            ->label('ID Azienda')
                            ->placeholder('UUID dell\'azienda')
                            ->required(),
                        Forms\Components\Select::make('request_type')
                            ->label('Tipo Richiesta')
                            ->options([
                                'access' => 'Accesso ai Dati',
                                'rectification' => 'Rettifica Dati',
                                'erasure' => 'Cancellazione Dati',
                                'portability' => 'Portabilità Dati',
                                'restriction' => 'Limitazione Trattamento',
                                'objection' => 'Opposizione al Trattamento',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('subject_name')
                            ->label('Nome Soggetto')
                            ->placeholder('Mario Rossi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('received_at')
                            ->label('Data Ricezione')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate('now'),
                        Forms\Components\DateTimePicker::make('due_date')
                            ->label('Data Scadenza')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->helper('Calcolata automaticamente: +30 giorni dalla data di ricezione'),
                            ->minDate(fn (callable $get): string => $get('received_at') ?? now()->toDateString()),
                        Forms\Components\TextInput::make('unicodoc_request_id')
                            ->label('Riferimento UnicoDoc')
                            ->placeholder('ID richiesta UnicoDoc')
                            ->numeric(),
                    ]),
                Forms\Components\Section::make('gestione_stato')
                    ->label('Gestione Stato')
                    ->description('Aggiorna lo stato della richiesta DSR')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Stato Attuale')
                            ->options(GdprDsrStatus::class)
                            ->required()
                            ->live(),
                    ]),
            ])
}
