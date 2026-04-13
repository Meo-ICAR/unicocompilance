<?php

namespace App\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;  // <-- QUESTA MANCAVA
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

class OamComplianceSimulator extends Widget implements HasForms
{
    use InteractsWithForms;

    // Disposizione a larghezza intera sulla dashboard
    protected int|string|array $columnSpan = 'full';
    protected string $view = 'filament.widgets.oam-compliance-simulator';

    public ?array $data = [];
    public array $sessions = [];

    public function mount(): void
    {
        $this->form->fill();
        // Dati iniziali di esempio
        $this->sessions[] = [
            'id' => uniqid(),
            'name' => 'Corso Antiriciclaggio Base (Simulazione)',
            'hours' => 15,
            'year' => date('Y'),
            'type' => 'Agente'
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(4)->schema([
                    TextInput::make('name')
                        ->label('Nome Corso')
                        ->required(),
                    TextInput::make('hours')
                        ->label('Ore')
                        ->numeric()
                        ->minValue(1)
                        ->required(),
                    Select::make('year')
                        ->label('Anno')
                        ->options([
                            '2024' => '2024',
                            '2025' => '2025'
                        ])
                        ->default('2024')
                        ->required(),
                    Select::make('type')
                        ->label('Qualifica')
                        ->options([
                            'Agente' => 'Agente',
                            'Dipendente' => 'Dipendente'
                        ])
                        ->default('Agente')
                        ->required(),
                ])
            ])
            ->statePath('data');
    }

    public function addSession(): void
    {
        $data = $this->form->getState();

        $this->sessions[] = [
            'id' => uniqid(),
            'name' => $data['name'],
            'hours' => (int) $data['hours'],
            'year' => $data['year'],
            'type' => $data['type'],
        ];

        // Resetta il form dopo l'inserimento
        $this->form->fill();
    }

    public function removeSession($id): void
    {
        $this->sessions = array_filter($this->sessions, fn($s) => $s['id'] !== $id);
    }

    // Proprietà calcolata per il totale delle ore
    public function getTotalHoursProperty(): int
    {
        return array_sum(array_column($this->sessions, 'hours'));
    }
}
