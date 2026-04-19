<?php

namespace App\Filament\Resources\GdprDsrRequests\Schemas;

use App\Enums\GdprDsrStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GdprDsrRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('informazioni_richiesta')
                    ->label('Informazioni Richiesta')
                    ->description('Dettagli della richiesta DSR (Data Subject Request)')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Select::make('request_type')
                            ->label('Tipo Richiesta')
                            ->options([
                                'access'        => 'Accesso ai Dati',
                                'rectification' => 'Rettifica Dati',
                                'erasure'       => 'Cancellazione Dati',
                                'portability'   => 'Portabilità Dati',
                                'restriction'   => 'Limitazione Trattamento',
                                'objection'     => 'Opposizione al Trattamento',
                            ])
                            ->required(),
                        TextInput::make('subject_name')
                            ->label('Nome Soggetto')
                            ->placeholder('Mario Rossi')
                            ->required()
                            ->maxLength(255),
                        DateTimePicker::make('received_at')
                            ->label('Data Ricezione')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                        DateTimePicker::make('due_date')
                            ->label('Data Scadenza')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->helperText('Calcolata automaticamente: +30 giorni dalla data di ricezione')
                            ->minDate(fn (callable $get): string => $get('received_at') ?? now()->toDateString()),
                        TextInput::make('unicodoc_request_id')
                            ->label('Riferimento UnicoDoc')
                            ->placeholder('ID richiesta UnicoDoc')
                            ->numeric(),
                    ])->columns(2),
                Section::make('gestione_stato')
                    ->label('Gestione Stato')
                    ->description('Aggiorna lo stato della richiesta DSR')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Select::make('status')
                            ->label('Stato Attuale')
                            ->options(GdprDsrStatus::class)
                            ->required()
                            ->live(),
                    ]),
            ]);
    }
}
