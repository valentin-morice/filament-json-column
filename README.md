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

### Personnalize the accent color
The tab selector menu uses the `slateblue` CSS color by default. However, you can chose any other color:
```php
FilamentJsonColumn::make('example')->accent('#FFFFFF') // The input needs to be a valid CSS color
```

### Display a single tab

If you'd like to use only one of the tabs, without giving your user the possibility to switch to another, use the following methods:
```php
FilamentJsonColumn::make('example')->editorOnly() // Displays only the editor tab

FilamentJsonColumn::make('example')->viewerOnly() // Displays only the viewer tab
```


## Credits
I've taken inspiration from the following plugins: [Pretty JSON](https://github.com/novadaemon/filament-pretty-json) & [JSONeditor](https://github.com/invaders-xx/filament-jsoneditor).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
