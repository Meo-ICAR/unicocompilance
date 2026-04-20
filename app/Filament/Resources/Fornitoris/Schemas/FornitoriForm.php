<?php

namespace App\Filament\Resources\Fornitoris\Schemas;

use App\Model\DB\Oam;
// use App\Services\ChecklistService;
// use App\Services\GeminiVisionService;
// use App\Traits\HasDocumentTypeFiltering;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
// use Filament\Actions\DeleteAction;
// use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
// use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
// use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FornitoriForm
{
    // use HasDocumentTypeFiltering;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. SEZIONE ANAGRAFICA E STATUS
                Section::make('Anagrafica e Inquadramento')
                    ->collapsible()
                    ->collapsed()
                    ->description('Dati principali e collegamento utente del collaboratore.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nome / Denominazione')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2)
                                ->live(debounce: 300)
                                ->afterStateUpdated(function (string $state, callable $set) {
                                    if (strlen($state) < 2) {
                                        return;
                                    }

                                    $suggestions = Oam::where('name', 'LIKE', '%' . $state . '%')
                                        ->limit(5)
                                        ->pluck('name')
                                        ->sort()
                                        ->toArray();

                                    if (!empty($suggestions)) {
                                        // Notifica l'utente con i suggerimenti
                                        Notification::make()
                                            ->title('Suggerimenti OAM')
                                            ->body('Nomi trovati: ' . implode(', ', $suggestions))
                                            ->info()
                                            ->send();
                                    }
                                }),
                            TextInput::make('email')
                                ->label('Email Lavoro')
                                ->email()
                                ->maxLength(100)
                                ->helperText('Email professionale per comunicazioni di lavoro'),
                            TextInput::make('email_personal')
                                ->label('Email Personale')
                                ->email()
                                ->maxLength(100)
                                ->helperText('Email personale per contatti diretti'),
                            TextInput::make('phone')
                                ->label('Telefono')
                                ->tel()
                                ->maxLength(20),
                            TextInput::make('tax_code')
                                ->label('Codice Fiscale')
                                ->maxLength(16)
                                ->placeholder('es. RSSMRA85A01H501Z')
                                ->helperText("Codice fiscale dell'agente")
                                ->unique(ignoreRecord: true, table: 'agents'),
                            Select::make('type')
                                ->label('Tipologia Collaboratore')
                                ->options([
                                    'Agente' => 'Agente',
                                    'Mediatore' => 'Mediatore',
                                    'Consulente' => 'Consulente',
                                    'Call Center' => 'Call Center',
                                ])
                                ->searchable(),
                            Select::make('supervisor_type')
                                ->label('Tipo Supervisore')
                                ->options([
                                    'no' => 'No',
                                    'si' => 'Sì',
                                    'filiale' => 'Filiale',
                                ])
                                ->default('no')
                                ->helperText('Se supervisore indicare e specificare se di filiale'),
                            Toggle::make('is_active')
                                ->label('Attivo/Convenzionato')
                                ->default(true)
                                ->inline(false),
                            Toggle::make('is_art108')
                                ->label('Esente Art. 108')
                                ->default(false)
                                ->inline(false)
                                ->helperText('Esente art. 108 - ex art. 128-novies TUB'),
                            Select::make('user_id')
                                ->label('Utente di Sistema Collegato')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->helperText("Associa questo profilo a un account per l'accesso al CRM."),
                            // company_id solitamente si gestisce in background col multi-tenancy,
                            // ma se serve selezionarlo a mano:
                            Select::make('company_branch_id')
                                ->label('Filiale di Riferimento')
                                ->relationship('companyBranch', 'name')
                                ->searchable()
                                ->preload()
                                ->nullable()
                                ->helperText('Filiale specifica di riferimento per questo agente'),
                        ]),
                        Textarea::make('description')
                            ->label('Note / Descrizione interna')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
                // 2. SEZIONE NORMATIVA E OAM
                Section::make('Dati OAM e Mandato')
                    ->collapsible()
                    ->collapsed()
                    ->description("Estremi di iscrizione all'elenco e date di validità del contratto.")
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('numero_iscrizione_rui')
                                ->label('Numero Iscrizione OAM')
                                ->maxLength(30)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $state, callable $set, callable $get) {
                                    if (empty($state)) {
                                        $set('oam_name', null);
                                        $set('oam_at', null);
                                        return;
                                    }

                                    $oam = Oam::where('numero_iscrizione_rui', $state)->first();

                                    if ($oam) {
                                        $set('oam_name', $oam->name);
                                        $set('oam_at', $oam->data_iscrizione);
                                    } else {
                                        $set('oam_name', null);
                                        $set('oam_at', null);
                                    }
                                }),
                            TextInput::make('oam')
                                ->label('Codice OAM')
                                ->maxLength(255),
                            TextInput::make('oam_name')
                                ->label('Denominazione registrata in OAM')
                                ->maxLength(255),
                            DatePicker::make('oam_at')
                                ->label('Data Iscrizione OAM')
                                ->displayFormat('d/m/Y'),
                            TextInput::make('ivass')
                                ->label('Codice Iscrizione IVASS')
                                ->maxLength(30),
                            TextInput::make('ivass_name')
                                ->label('Denominazione IVASS')
                                ->maxLength(255),
                            Select::make('ivass_section')
                                ->label('Sezione IVASS')
                                ->options([
                                    'A' => 'Sezione A',
                                    'B' => 'Sezione B',
                                    'C' => 'Sezione C',
                                    'D' => 'Sezione D',
                                    'E' => 'Sezione E',
                                ])
                                ->nullable(),
                            DatePicker::make('ivass_at')
                                ->label('Data Iscrizione IVASS')
                                ->displayFormat('d/m/Y'),
                            //   SpatieMediaLibraryFileUpload::make('identity_document')
                            //     ->collection('identity_documents')
                            //   ->label('Documento di Identità'),
                            // TextInput::make('nome'),
                            // TextInput::make('cognome'),
                            // TextInput::make('numero_documento'),
                        ]),
                        Grid::make(2)->schema([
                            DatePicker::make('stipulated_at')
                                ->label('Data Inizio Mandato')
                                ->displayFormat('d/m/Y')
                                ->required(),
                            DatePicker::make('dismissed_at')
                                ->label('Data Cessazione Rapporto')
                                ->displayFormat('d/m/Y')
                                ->helperText('Compilare solo in caso di interruzione del rapporto.'),
                        ]),
                    ]),
                // 3. SEZIONE FISCALE ED ENASARCO
                Section::make('Fiscale ed Enasarco')
                    ->collapsible()
                    ->collapsed()
                    ->description('Dati per la fatturazione e inquadramento previdenziale.')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('vat_name')
                                ->label('Ragione Sociale Fiscale')
                                ->maxLength(255),
                            TextInput::make('piva')
                                ->label('CF / Partita IVA')
                                ->maxLength(16),
                        ]),
                    ]),
            ]);
    }
}
