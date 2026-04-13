<?php

namespace App\Filament\Resources\GdprDataBreaches\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components;
use App\Enums\GdprBreachStatus;

class GdprDataBreachForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('dettagli_violazione')
                    ->label('Dettagli Violazione')
                    ->description('Informazioni sulla violazione dati GDPR')
                    ->icon('heroicon-o-shield-exclamation')
                    ->schema([
                        Forms\Components\TextInput::make('company_id')
                            ->label('ID Azienda')
                            ->placeholder('UUID dell\'azienda')
                            ->required(),
                        Forms\Components\DateTimePicker::make('incident_date')
                            ->label('Data Incidente')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate('now'),
                        Forms\Components\DateTimePicker::make('discovery_date')
                            ->label('Data Scoperta')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate('now')
                            ->after('incident_date'),
                        Forms\Components\Select::make('nature_of_breach')
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
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('subjects_affected_count')
                            ->label('Numero Soggetti Coinvolti')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Forms\Components\Textarea::make('containment_measures')
                            ->label('Misure di Contenimento')
                            ->rows(4)
                            ->helper('Descrivi le azioni intraprese per limitare il danno'),
                    ]),
                Forms\Components\Section::make('notifica_authorita')
                    ->label('Notifica Autorità')
                    ->description('Gestione della notifica alle autorità di protezione dati')
                    ->icon('heroicon-o-flag')
                    ->schema([
                        Forms\Components\Toggle::make('is_notified_to_authority')
                            ->label('Notificata all\'Autorità')
                            ->helper('Se selezionato, la data di notifica diventa obbligatoria'),
                            ->live(),
                        Forms\Components\DateTimePicker::make('notification_date')
                            ->label('Data Notifica')
                            ->displayFormat('d/m/Y')
                            ->visible(fn (callable $get): bool => $get('is_notified_to_authority')),
                            ->required(fn (callable $get): bool => $get('is_notified_to_authority')),
                    ]),
                Forms\Components\Section::make('gestione_stato')
                    ->label('Gestione Stato')
                    ->description('Controllo dello stato della violazione')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Stato Attuale')
                            ->options(GdprBreachStatus::class)
                            ->required()
                            ->live(),
                    ]),
            ])
}
