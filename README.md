# filament-json-column

A simple package to view and edit your JSON columns in Filament.

![image](https://github.com/valentin-morice/filament-json-column/assets/100000204/41212480-f635-4d50-b967-cad5dbda6dc9)
![image](https://github.com/valentin-morice/filament-json-column/assets/100000204/29591beb-524b-4671-b4ea-d5ec6b1f5705)


## Installation

You can install the package via composer:

```bash
composer require valentin-morice/filament-json-column
```

## Usage

The filament-json-column plugin works as any other Filament Form Builder class. Make sure the column on which it is called is casted to **JSON** or **array** within your Eloquent model.

```php
public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FilamentJsonColumn::make('example'),
            ]);
    }
```

It provides you with two tabs: `Viewer` & `Editor`. The `Viewer` tab pretty prints your JSON data, while the `Editor` tab lets you edit it conveniently.
All the methods provided by the plugin accept closures, injected with standard Filament [utilities](https://filamentphp.com/docs/3.x/forms/advanced#form-component-utility-injection).

### Personnalize the accent color
The tab selector menu uses the `slateblue` CSS color by default. However, you can choose any other color:
```php
FilamentJsonColumn::make('example')->accent(string '#FFFFFF'|Closure); // The input needs to be a valid CSS color
```

### Display a single tab

If you'd like to use only one of the tabs, without giving your user the possibility to switch to another, use the following methods:
```php
FilamentJsonColumn::make('example')->editorOnly(bool|Closure); // Displays only the editor tab
FilamentJsonColumn::make('example')->viewerOnly(bool|Closure); // Displays only the viewer tab
```

### Change the editor's height

```php
FilamentJsonColumn::make('example')->editorHeight(int 500|Closure); // Accepts an int, defaults to 300
```


## Credits
I've taken inspiration from the following plugins: [Pretty JSON](https://github.com/novadaemon/filament-pretty-json) & [JSONeditor](https://github.com/invaders-xx/filament-jsoneditor).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
