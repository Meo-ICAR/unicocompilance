<?php

namespace App\Filament\Resources\AmlSosReports\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components;
use App\Enums\AmlReportStatus;
use App\Models\AmlSosReport;

class AmlSosReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('informazioni_pratica')
                    ->label('Informazioni Pratica')
                    ->description('Dettagli generali della segnalazione AML')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\TextInput::make('practice_reference')
                            ->label('Riferimento Pratica BPM')
                            ->placeholder('es. PRJ-2024-001')
                            ->required(),
                        Forms\Components\Select::make('agent_id')
                            ->label('Agente')
                            ->relationship('agent')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Textarea::make('internal_evaluation')
                            ->label('Valutazione Interna')
                            ->rows(3),
                    ]),
                Forms\Components\Section::make('dettagli_sospetto')
                    ->label('Dettagli Sospetto')
                    ->description('Indicatori di anomalia e misure di contenimento')
                    ->icon('heroicon-o-shield-exclamation')
                    ->schema([
                        Forms\Components\CheckboxList::make('suspicion_indicators')
                            ->label('Indicatori Sospetto')
                            ->options([
                                '1A' => 'Operazioni sospette per importo elevato',
                                '1B' => 'Operazioni frammentate al di sotto della soglia',
                                '2A' => 'Struttura operativa complessa o inusuale',
                                '2B' => 'Operazioni senza giustificazione economica',
                                '3A' => 'Comportamento anomalo del cliente',
                                '3B' => 'Frequenza anomala delle operazioni',
                                '4A' => 'Operazioni con paesi a rischio',
                                '4B' => 'Operazioni con soggetti sanzionati',
                                '5A' => 'Utilizzo di strumenti di pagamento anomali',
                                '5B' => 'Operazioni in contanti anomale',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('containment_measures')
                            ->label('Misure di Contenimento')
                            ->rows(4),
                    ]),
                Forms\Components\Section::make('notifica_uif')
                    ->label('Notifica UIF')
                    ->description('Gestione della comunicazione alle autorità')
                    ->icon('heroicon-o-flag')
                    ->schema([
                        Forms\Components\Toggle::make('forwarded_to_fiu')
                            ->label('Inoltrata alla UIF')
                            ->helper('Se selezionato, il protocollo UIF diventa obbligatorio'),
                        Forms\Components\TextInput::make('fiu_protocol_number')
                            ->label('Protocollo UIF')
                            ->placeholder('es. UIF-2024-12345')
                            ->visible(fn (callable $get): bool => $get('forwarded_to_fiu'))
                            ->required(fn (callable $get): bool => $get('forwarded_to_fiu')),
                        Forms\Components\FileUpload::make('receipt_document_id')
                            ->label('Documento Ricevuta UIF')
                            ->helper('Carica la ricevuta ufficiale della UIF')
                            ->visible(fn (callable $get): bool => $get('forwarded_to_fiu'))
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120) // 5MB
                            ->directory('aml-receipts'),
                    ]),
                Forms\Components\Section::make('gestione_stato')
                    ->label('Gestione Stato')
                    ->description('Controllo dello stato della segnalazione')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Stato')
                            ->options(AmlReportStatus::class)
                            ->required()
                            ->live(),
                    ]),
            ]);
    }
}
