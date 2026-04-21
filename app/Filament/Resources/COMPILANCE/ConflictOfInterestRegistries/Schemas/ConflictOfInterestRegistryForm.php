<?php

namespace App\Filament\Resources\COMPILANCE\ConflictOfInterestRegistries\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ConflictOfInterestRegistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Textarea::make('conflict_description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('mitigation_strategy')
                    ->columnSpanFull(),
                DateTimePicker::make('approved_by_compliance_at'),
            ]);
    }
}
