<?php

namespace App\Filament\RelationManagers;

use App\Models\COMPILANCE\TrainingSession;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingSessionsRelationManager extends RelationManager
{
    protected static string $relationship = 'trainingSessions';

    protected static ?string $title = 'Sessioni di Formazione';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('course_name')
            ->columns([
                TextColumn::make('course_name')
                    ->label('Sessione Formativa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('provider')
                    ->label('Fornitore')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hours')
                    ->label('Ore')
                    ->sortable(),
                TextColumn::make('completion_date')
                    ->label('Data Completamento')
                    ->date()
                    ->sortable(),
                TextColumn::make('expiry_date')
                    ->label('Data Scadenza')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nuova Registrazione'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Modifica'),
                DeleteAction::make()
                    ->label('Elimina'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Elimina Selezionati'),
                ]),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('course_name')
                    ->label('Nome Corso')
                    ->required(),
                TextInput::make('provider')
                    ->label('Fornitore')
                    ->required(),
                TextInput::make('hours')
                    ->label('Ore')
                    ->numeric()
                    ->default(1)
                    ->required(),
                DatePicker::make('completion_date')
                    ->label('Data Completamento')
                    ->required(),
                DatePicker::make('expiry_date')
                    ->label('Data Scadenza'),
                TextInput::make('certificate_path')
                    ->label('Percorso Certificato')
                    ->maxLength(255),
                Textarea::make('notes')
                    ->label('Note')
                    ->maxLength(1000),
            ]);
    }
}
