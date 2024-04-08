# filament-json-column

A simple package to view and edit your JSON columns in Filament.

## Installation

You can install the package via composer:

```bash
composer require valentin-morice/filament-json-column
```

## Usage

The filament-json-column plugin works as any other Filament Form Builder class. Make sure the column on which it is called is casted to JSON or array within your Eloquent model.

```php
public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FilamentJsonColumn::make('custom-fields'),
            ]);
    }
```

It provides you with two tabs: `Viewer` & `Editor`. The `Viewer` tab pretty prints your JSON data, while the `Editor` tab lets you edit it conveniently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
