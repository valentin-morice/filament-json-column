<?php

namespace ValentinMorice\FilamentJsonColumn\Tests;

use Filament\Forms\FormsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use ValentinMorice\FilamentJsonColumn\FilamentJsonColumnServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            FormsServiceProvider::class,
            SupportServiceProvider::class,
            FilamentJsonColumnServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:AckfSECXI/7zz/iuZR99w6z2g3WBpKF8+D+X/0Fk5tI=');
    }
}
