<?php

namespace ValentinMorice\FilamentJsonColumn;

use Filament\Forms\Components\Field;

class FilamentJsonColumn extends Field
{
    protected string $view = 'filament-json-column::index';

    protected string $mode = '';

    protected string $accent = 'slateblue';

    protected function setUp(): void
    {
        parent::setUp();


        $this->afterStateHydrated(static function (FilamentJsonColumn $component, $state): void {
            if(is_array($state)) {
                $state = json_encode($state);
            }

            $component->state((array) $state);
        });
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getAccent(): string
    {
        return $this->accent;
    }

    public function editorOnly(): static
    {
        $this->mode = 'editor';

        return $this;
    }

    public function viewerOnly(): static
    {
        $this->mode = 'viewer';

        return $this;
    }

    public function accent(string $hexcode): static
    {
        $this->accent = $hexcode;

        return $this;
    }
}
