<?php

namespace App\Filament\Resources\COMPILANCE\TrainingSessions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TrainingSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),
                TextInput::make('trainee_type')
                    ->required(),
                TextInput::make('trainee_id')
                    ->required()
                    ->numeric(),
                TextInput::make('course_name')
                    ->required(),
                TextInput::make('provider')
                    ->required(),
                TextInput::make('hours')
                    ->required()
                    ->numeric(),
                DatePicker::make('completion_date')
                    ->required(),
                DatePicker::make('expiry_date'),
                TextInput::make('certificate_path'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
