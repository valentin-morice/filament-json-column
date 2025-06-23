<?php

namespace ValentinMorice\FilamentJsonColumn\Tests\Support;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Livewire\Component;
use ValentinMorice\FilamentJsonColumn\JsonColumn;

class FormTestComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?array $options = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        $component = JsonColumn::make('json');

        foreach ($this->options as $method => $value) {
            $component = $component->{$method}($value);
        }

        return $schema
            ->schema([
                $component,
            ])
            ->statePath('data');
    }

    public function render(): string
    {
        return <<<'BLADE'
        <div>
            <form wire:submit.prevent="save">
                {{ $this->form }}
                <button type="submit">Submit</button>
            </form>
        </div>
        BLADE;
    }

    public function save(): void
    {
        $this->validate();
        $formData = $this->form->getState();
    }
} 