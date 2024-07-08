# Filament Laravel Route List Plugin

Lists Laravel routes in a Filament panel.

## Installation

You can install the package via composer:

```bash
composer require bondarde/filament-route-list
```

## Usage

Add this plugin in your panel provider:

```php
use BondarDe\FilamentRouteList\FilamentRouteListPlugin;

public function panel(Panel $panel): Panel
    {
       return $panel
            ->id()
            // ...
            ->plugin(FilamentRouteListPlugin::make())
            // ...
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Alexander Bondar](https://github.com/bondarde)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
