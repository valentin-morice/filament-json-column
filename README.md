# filament-json-column

A simple package to view and edit your JSON columns in Filament.

![image](https://github.com/valentin-morice/filament-json-column/assets/100000204/41212480-f635-4d50-b967-cad5dbda6dc9)
![image](https://github.com/valentin-morice/filament-json-column/assets/100000204/29591beb-524b-4671-b4ea-d5ec6b1f5705)

## Installation (Stable)

You can install the stable version of the package via composer:

```bash
composer require valentin-morice/filament-json-column
```

## Pre-Release / Dev Version (v3.0)

To try out the upcoming v3.0, compatible with Filament v4, you can require the `dev` branch directly.

Thanks to [@safwendammak](https://github.com/safwendammak) for his pull-request.

**Note: This branch is under active development and may contain unstable code.**

Add the following to your `composer.json`:

```json
{
    "require": {
        "valentin-morice/filament-json-column": "dev-dev"
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

Then run `composer update`:

```bash
composer update valentin-morice/filament-json-column
```

## Usage

The `filament-json-column` plugin works as any other Filament Form Builder or Infolist classes. Make sure the column on which it is called is cast to **JSON** or **array** within your Eloquent model.

```php
use ValentinMorice\FilamentJsonColumn\JsonColumn;
use ValentinMorice\FilamentJsonColumn\JsonInfolist;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            JsonColumn::make('example'),
        ]);
}

// An infolist component is also available.
public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            JsonInfolist::make('example'),
        ]);
}
```

The form component provides you with two tabs: `Viewer` & `Editor`. The `Viewer` tab pretty prints your JSON data, while the `Editor` tab lets you edit it conveniently.
All the methods provided by the plugin accept closures, injected with standard Filament [utilities](https://filamentphp.com/docs/3.x/forms/advanced#form-component-utility-injection).

### Personalize the accent color
The tab selector menu uses the `slateblue` CSS color by default. However, you can choose any other color:
```php
JsonColumn::make('example')->accent(string '#FFFFFF'|Closure); // The input needs to be a valid CSS color
```

### Display a single tab

If you'd like to use only one of the tabs, without giving your user the possibility to switch to another, use the following methods:
```php
JsonColumn::make('example')->editorOnly(bool|Closure); // Displays only the editor tab
JsonColumn::make('example')->viewerOnly(bool|Closure); // Displays only the viewer tab
```

### Change the height

```php
JsonColumn::make('example')->editorHeight(int 500|Closure); // Accepts an int, defaults to 300
JsonColumn::make('example')->viewerHeight(int 500|Closure); // Accepts an int, defaults to 300
```

### Editor modes
Customize the editor modes. Accepted values (and default) are: `['code', 'form', 'text', 'tree', 'view', 'preview']`
```php
JsonColumn::make('example')->modes(array|Closure ['code', 'text', 'tree']);
```

### Validation

Values are validated as proper JSON by default.

## Credits
I've taken inspiration from the following plugins: [Pretty JSON](https://github.com/novadaemon/filament-pretty-json) & [JSONeditor](https://github.com/invaders-xx/filament-jsoneditor).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
