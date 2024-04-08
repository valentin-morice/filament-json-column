# filament-json-column

A simple package to view and edit your JSON columns in Filament. Supports dark-mode.

![image](https://github.com/valentin-morice/filament-json-column/assets/100000204/79b3c63c-e657-43d1-b78b-01a1b91f4f6c)
![image](https://github.com/valentin-morice/filament-json-column/assets/100000204/b82ca746-4f1f-488d-81f9-ac0dc3b150f5)




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

## Credits
I've taken inspiration from the following plugins: [Pretty JSON](https://github.com/novadaemon/filament-pretty-json) & [JSONeditor](https://github.com/invaders-xx/filament-jsoneditor).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
