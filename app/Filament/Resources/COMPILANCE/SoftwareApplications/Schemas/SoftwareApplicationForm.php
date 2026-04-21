<?php

namespace App\Filament\Resources\COMPILANCE\SoftwareApplications\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SoftwareApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),
                Select::make('software_category_id')
                    ->relationship('softwareCategory', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('provider_name'),
                TextInput::make('website_url')
                    ->url(),
                TextInput::make('api_url')
                    ->url(),
                TextInput::make('sandbox_url')
                    ->url(),
                TextInput::make('api_key_url')
                    ->url(),
                Textarea::make('api_parameters')
                    ->columnSpanFull(),
                Toggle::make('is_cloud')
                    ->required(),
                Toggle::make('is_data_eu')
                    ->required(),
                Toggle::make('is_iso27001_certified')
                    ->required(),
                TextInput::make('apikey'),
                TextInput::make('wallet_balance')
                    ->numeric(),
            ]);
    }
}
