<?php

namespace App\Filament\Resources\ComplaintRegistries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components;
use App\Enums\ComplaintStatus;

class ComplaintRegistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('informazioni_reclamo')
                    ->label('Informazioni Reclamo')
                    ->description('Dettagli principali del reclamo')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        Forms\Components\TextInput::make('complaint_number')
                            ->label('Numero Reclamo')
                            ->placeholder('es. REC-2024-001')
                            ->required()
                            ->unique(),
                            ->disabled(fn (callable $get): bool => $get('id') !== null),
                        Forms\Components\TextInput::make('complainant_name')
                            ->label('Nome Richiedente')
                            ->placeholder('Mario Rossi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category')
                            ->label('Categoria')
                            ->options([
                                'delay' => 'Ritardo',
                                'behavior' => 'Comportamento',
                                'privacy' => 'Privacy',
                                'fraud' => 'Frode',
                                'quality' => 'Qualità',
                                'contract' => 'Contrattuale',
                                'other' => 'Altro',
                            ])
                            ->required(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Descrizione')
                            ->placeholder('Descrivi dettagliatamente il problema...')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('financial_impact')
                            ->label('Impatto Finanziario (€)')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('€')
                            ->placeholder('0.00')
                    ]),
                Forms\Components\Section::make('gestione_stato')
                    ->label('Gestione Stato')
                    ->description('Aggiorna lo stato del reclamo')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Stato Attuale')
                            ->options(ComplaintStatus::class)
                            ->required()
                            ->live(),
                    ]),
            ])
}
