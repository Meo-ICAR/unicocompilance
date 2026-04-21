<?php

namespace App\Filament\Resources\COMPILANCE\SoftwareApplications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SoftwareApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->searchable(),
                TextColumn::make('softwareCategory.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('provider_name')
                    ->searchable(),
                TextColumn::make('website_url')
                    ->searchable(),
                TextColumn::make('api_url')
                    ->searchable(),
                TextColumn::make('sandbox_url')
                    ->searchable(),
                TextColumn::make('api_key_url')
                    ->searchable(),
                IconColumn::make('is_cloud')
                    ->boolean(),
                IconColumn::make('is_data_eu')
                    ->boolean(),
                IconColumn::make('is_iso27001_certified')
                    ->boolean(),
                TextColumn::make('apikey')
                    ->searchable(),
                TextColumn::make('wallet_balance')
                    ->numeric()
                    ->sortable(),
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
