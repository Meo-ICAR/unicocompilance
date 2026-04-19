<?php

namespace App\Filament\Resources\TrainingSessions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('dettagli_sessione')
                    ->label('Dettagli Sessione')
                    ->description('Informazioni sul corso di formazione erogato')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        TextInput::make('course_name')
                            ->label('Nome Corso')
                            ->placeholder('es. Corso Antiriciclaggio Base')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('provider')
                            ->label('Ente Erogatore')
                            ->placeholder('es. OAM, IVASS, Associazione...')
                            ->maxLength(255),
                        TextInput::make('hours')
                            ->label('Ore di Formazione')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(999)
                            ->required()
                            ->suffix('ore'),
                        DatePicker::make('completion_date')
                            ->label('Data Completamento')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                        DatePicker::make('expiry_date')
                            ->label('Data Scadenza')
                            ->displayFormat('d/m/Y')
                            ->helperText('Lascia vuoto se il corso non ha scadenza')
                            ->after('completion_date'),
                        Textarea::make('notes')
                            ->label('Note')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('partecipante')
                    ->label('Partecipante')
                    ->description('Soggetto che ha frequentato la sessione')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('trainee_id')
                            ->label('ID Partecipante')
                            ->numeric()
                            ->required(),
                        Select::make('trainee_type')
                            ->label('Tipo Partecipante')
                            ->options([
                                'App\\Models\\Agent'    => 'Consulente / Agente',
                                'App\\Models\\Employee' => 'Dipendente / Backoffice',
                            ])
                            ->required(),
                    ])->columns(2),

                Section::make('certificato')
                    ->label('Certificato')
                    ->description('Documento attestante il completamento del corso')
                    ->icon('heroicon-o-document-check')
                    ->schema([
                        FileUpload::make('certificate_path')
                            ->label('Certificato (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->directory('training-certificates')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
