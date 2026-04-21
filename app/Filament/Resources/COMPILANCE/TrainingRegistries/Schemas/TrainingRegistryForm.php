<?php

namespace App\Filament\Resources\COMPILANCE\TrainingRegistries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TrainingRegistryForm
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
                TextInput::make('course_name')
                    ->required(),
                TextInput::make('regulatory_framework')
                    ->required(),
                DatePicker::make('completed_at')
                    ->required(),
                DatePicker::make('valid_until'),
                TextInput::make('certificate_document_id'),
            ]);
    }
}
