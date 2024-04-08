<?php

namespace ValentinMorice\FilamentJsonColumn;

use Filament\Forms\Components\Field;

class FilamentJsonColumn extends Field
{
    protected string $view = 'filament-json-column::index';

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
}
