<?php

namespace BondarDe\FilamentRouteList;

use BondarDe\FilamentRouteList\Filament\Resources\LaravelRouteResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentRouteListPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-route-list';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                LaravelRouteResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
