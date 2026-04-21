<?php

namespace App\Filament\Resources\COMPILANCE\ClientiEmployees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClientiEmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('clienti_id')
                    ->relationship('clienti', 'name'),
                Select::make('company_id')
                    ->relationship('company', 'name'),
                TextInput::make('personable_type'),
                TextInput::make('personable_id'),
                TextInput::make('num_iscr_intermediario'),
                TextInput::make('num_iscr_collaboratori_ii_liv'),
                TextInput::make('usercode'),
                TextInput::make('description'),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
