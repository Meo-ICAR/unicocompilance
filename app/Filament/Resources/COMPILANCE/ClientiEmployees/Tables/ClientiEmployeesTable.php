<?php

namespace App\Filament\Resources\COMPILANCE\ClientiEmployees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientiEmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('clienti.name')
                    ->searchable(),
                TextColumn::make('company.name')
                    ->searchable(),
                TextColumn::make('personable_type')
                    ->searchable(),
                TextColumn::make('personable_id')
                    ->searchable(),
                TextColumn::make('num_iscr_intermediario')
                    ->searchable(),
                TextColumn::make('num_iscr_collaboratori_ii_liv')
                    ->searchable(),
                TextColumn::make('usercode')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
