<?php

namespace App\Filament\Resources\TrainingRegistries\Schemas;

use App\Enums\RegulatoryFramework;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingRegistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('informazioni_corso')
                    ->label('Informazioni Corso')
                    ->description('Dettagli del corso di formazione')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Select::make('user_id')
                            ->label('Agente')
                            ->relationship('user')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('course_name')
                            ->label('Nome Corso')
                            ->placeholder('es. Corso Antiriciclaggio Base')
                            ->required()
                            ->maxLength(255),
                        Select::make('regulatory_framework')
                            ->label('Quadro Normativo')
                            ->options(RegulatoryFramework::class)
                            ->required(),
                        DatePicker::make('completed_at')
                            ->label('Data Completamento')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                        DatePicker::make('valid_until')
                            ->label('Valido Fino al')
                            ->displayFormat('d/m/Y')
                            ->helperText('Lascia vuoto se il corso non ha scadenza')
                            ->after('completed_at'),
                        FileUpload::make('certificate_document_id')
                            ->label('Certificato')
                            ->helperText('Carica il certificato di completamento (PDF, PNG)')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('training-certificates'),
                    ])->columns(2),
            ]);
    }
}
