<?php

namespace ValentinMorice\FilamentJsonColumn;

use Filament\Forms\Components\Field;

class FilamentJsonColumn extends Field
{
    protected string $view = 'filament-json-column::index';

    protected string $mode = '';

    protected string $accent = 'slateblue';

    protected int $editorHeight = 300;

    protected function setUp(): void
    {
        parent::setUp();

        $this->beforeStateDehydrated(function(FilamentJsonColumn $component, $state) {
            if (is_string($state)) {
                $component->state(json_decode($state, true));
            }
        });
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getEditorHeight(): string
    {
        return $this->editorHeight.'px';
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

    public function editorHeight(int $heightInPx): static
    {
        $this->editorHeight = $heightInPx;

        return $this;
    }

    public function accent(string $hexcode): static
    {
        $this->accent = $hexcode;

        return $this;
    }
}
