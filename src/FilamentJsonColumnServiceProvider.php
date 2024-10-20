<?php

namespace ValentinMorice\FilamentJsonColumn;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentJsonColumnServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-json-column';

    public static string $viewNamespace = 'filament-json-column';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make('jsoneditor-js-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.0.2/jsoneditor.min.js'),
            Js::make('app', __DIR__ . '/../resources/js/app.js'),
            Css::make('app', __DIR__ . '/../resources/css/app.css'),
            Css::make('jsoneditor-css-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.0.2/jsoneditor.min.css'),
        ]);
    }
}
