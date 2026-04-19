<?php

namespace App\Filament\Resources\GdprDataBreaches\Schemas;

use App\Enums\GdprBreachStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GdprDataBreachForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('dettagli_violazione')
                    ->label('Dettagli Violazione')
                    ->description('Informazioni sulla violazione dati GDPR')
                    ->icon('heroicon-o-shield-exclamation')
                    ->schema([
                        DateTimePicker::make('incident_date')
                            ->label('Data Incidente')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                        DateTimePicker::make('discovery_date')
                            ->label('Data Scoperta')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate(now())
                            ->after('incident_date'),
                        Select::make('nature_of_breach')
                            ->label('Natura Violazione')
                            ->options([
                                'unauthorized_access' => 'Accesso Non Autorizzato',
                                'data_loss'           => 'Perdita Dati',
                                'ransomware'          => 'Ransomware',
                                'phishing'            => 'Phishing',
                                'malware'             => 'Malware',
                                'physical_theft'      => 'Furto Fisico',
                                'human_error'         => 'Errore Umano',
                                'other'               => 'Altro',
                            ])
                            ->required(),
                        TextInput::make('subjects_affected_count')
                            ->label('Numero Soggetti Coinvolti')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Textarea::make('containment_measures')
                            ->label('Misure di Contenimento')
                            ->rows(4)
                            ->helperText('Descrivi le azioni intraprese per limitare il danno'),
                    ])->columns(2),
                Section::make('notifica_authorita')
                    ->label('Notifica Autorità')
                    ->description('Gestione della notifica alle autorità di protezione dati')
                    ->icon('heroicon-o-flag')
                    ->schema([
                        Toggle::make('is_notified_to_authority')
                            ->label('Notificata all\'Autorità')
                            ->helperText('Se selezionato, la data di notifica diventa obbligatoria')
                            ->live(),
                        DateTimePicker::make('notification_date')
                            ->label('Data Notifica')
                            ->displayFormat('d/m/Y')
                            ->visible(fn (callable $get): bool => (bool) $get('is_notified_to_authority'))
                            ->required(fn (callable $get): bool => (bool) $get('is_notified_to_authority')),
                    ]),
                Section::make('gestione_stato')
                    ->label('Gestione Stato')
                    ->description('Controllo dello stato della violazione')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Select::make('status')
                            ->label('Stato Attuale')
                            ->options(GdprBreachStatus::class)
                            ->required()
                            ->live(),
                    ]),
            ]);
    }
}
