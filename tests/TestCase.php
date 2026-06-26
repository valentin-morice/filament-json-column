<?php

namespace ValentinMorice\FilamentJsonColumn\Tests;

use Filament\Actions\ActionsServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Livewire\LivewireServiceProvider;
use Livewire\Mechanisms\DataStore;
use Orchestra\Testbench\TestCase as Orchestra;
use ValentinMorice\FilamentJsonColumn\FilamentJsonColumnServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Livewire registers its DataStore mechanism as a *shared* instance, and the
        // store() helper resolves it on every get/set/has. Filament's SupportServiceProvider
        // rebinds DataStore to its DataStoreOverride using a transient bind(), so under
        // Livewire's test harness every store() call returns a fresh, empty instance —
        // writes (e.g. the validation error bag) are lost and rendering throws. A real
        // HTTP request re-instances the mechanism per request, so this only bites in tests.
        // Pin it back to a single shared instance.
        $this->app->instance(DataStore::class, $this->app->make(DataStore::class));
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            ActionsServiceProvider::class,
            SchemasServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            FilamentJsonColumnServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:AckfSECXI/7zz/iuZR99w6z2g3WBpKF8+D+X/0Fk5tI=');
    }
}
