<?php

namespace App\Filament\Resources\TrainingRegistries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components;
use App\Enums\RegulatoryFramework;

class TrainingRegistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('informazioni_corso')
                    ->label('Informazioni Corso')
                    ->description('Dettagli del corso di formazione')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Agente')
                            ->relationship('user')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('course_name')
                            ->label('Nome Corso')
                            ->placeholder('es. Corso Antiriciclaggio Base')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('regulatory_framework')
                            ->label('Quadro Normativo')
                            ->options(RegulatoryFramework::class)
                            ->required(),
                        Forms\Components\DatePicker::make('completed_at')
                            ->label('Data Completamento')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate('now'),
                        Forms\Components\DatePicker::make('valid_until')
                            ->label('Valido Fino al')
                            ->displayFormat('d/m/Y')
                            ->helper('Lascia vuoto se il corso non ha scadenza')
                            ->after('completed_at'),
                        Forms\Components\FileUpload::make('certificate_document_id')
                            ->label('Certificato')
                            ->helper('Carica il certificato di completamento (PDF, PNG)')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120) // 5MB
                            ->directory('training-certificates'),
                    ]),
            ])
}
