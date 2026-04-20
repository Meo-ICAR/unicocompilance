<?php declare(strict_types=1);

namespace App\Filament\Resources\Governance;

use App\Filament\Resources\Governance\Pages\CreateTrainingSession;
use App\Filament\Resources\Governance\Pages\EditTrainingSession;
use App\Filament\Resources\Governance\Pages\ListTrainingSessions;
use App\Models\COMPILANCE\TrainingSession;
use App\Models\Agent;
use App\Models\Employee;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BackedEnum;
use UnitEnum;

class TrainingSessionResource extends Resource
{
    protected static ?string $model = TrainingSession::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Sessioni di Formazione';

    protected static ?string $slug = 'governance/training-sessions';

    protected static ?string $recordTitleAttribute = 'course_name';

    protected static ?string $cluster = GovernanceCluster::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Dettagli Corso')
                ->schema([
                    Select::make('trainee_type')
                        ->label('Tipo Corsista')
                        ->options([
                            Agent::class => 'Consulente / Agente',
                            Employee::class => 'Dipendente / Backoffice',
                        ])
                        ->required()
                        ->live()
                        ->columnSpanFull(),
                    Select::make('trainee_id')
                        ->label('Corsista')
                        ->options(fn(callable $get) => match ($get('trainee_type')) {
                            Agent::class => Agent::pluck('name', 'id'),
                            Employee::class => Employee::pluck('name', 'id'),
                            default => [],
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->visible(fn(callable $get) => filled($get('trainee_type'))),
                    TextInput::make('course_name')
                        ->label('Nome Corso')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('hours')
                        ->label('Ore')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(999)
                        ->required(),
                    DatePicker::make('completion_date')
                        ->label('Data Completamento')
                        ->required()
                        ->native(false),
                    TextInput::make('provider')
                        ->label('Ente Erogatore')
                        ->maxLength(255)
                        ->placeholder('Es. OAM, IVASS, Associazione...'),
                    FileUpload::make('certificate_path')
                        ->label('Certificato')
                        ->disk('private')
                        ->directory('certificates')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(5120)
                        ->downloadable()
                        ->openable()
                        ->columnSpanFull(),
                    Textarea::make('notes')
                        ->label('Note')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainee.name')
                    ->label('Corsista')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHasMorph(
                            'trainee',
                            [Agent::class, Employee::class],
                            fn(Builder $q) => $q->where('name', 'like', "%{$search}%")
                        );
                    })
                    ->sortable()
                    ->limit(30),
                TextColumn::make('trainee_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        Agent::class => 'Agente',
                        Employee::class => 'Dipendente',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        Agent::class => 'info',
                        Employee::class => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('course_name')
                    ->label('Corso')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('hours')
                    ->label('Ore')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('Totale Ore')),
                TextColumn::make('completion_date')
                    ->label('Data Completamento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('provider')
                    ->label('Ente Erogatore')
                    ->searchable()
                    ->limit(30),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('trainee_type')
                    ->label('Tipo Corsista')
                    ->options([
                        Agent::class => 'Consulente / Agente',
                        Employee::class => 'Dipendente / Backoffice',
                    ]),
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->with('trainee'))
            ->striped()
            ->recordClasses(fn(TrainingSession $record) => self::getRecordClasses($record));
    }

    public static function getRecordClasses(TrainingSession $record): ?string
    {
        $traineeHours = TrainingSession::query()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('trainee_type', $record->trainee_type)
            ->where('trainee_id', $record->trainee_id)
            ->sum('hours');

        if ($traineeHours < 60) {
            return 'bg-yellow-100 dark:bg-yellow-900/30';
        }

        return null;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingSessions::route('/'),
            'create' => CreateTrainingSession::route('/create'),
            'edit' => EditTrainingSession::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
