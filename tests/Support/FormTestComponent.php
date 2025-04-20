<?php

namespace ValentinMorice\FilamentJsonColumn\Tests\Support;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
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

    public function form(Form $form): Form
    {
        $component = JsonColumn::make('json');

        foreach ($this->options as $method => $value) {
            $component = $component->{$method}($value);
        }

        return $form
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
        $formData = $this->form->getState();
    }
}
