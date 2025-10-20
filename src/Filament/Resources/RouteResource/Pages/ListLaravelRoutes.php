<?php

namespace BondarDe\FilamentRouteList\Filament\Resources\RouteResource\Pages;

use BondarDe\FilamentRouteList\Filament\Resources\LaravelRouteResource;
use BondarDe\FilamentRouteList\FilamentRouteList;
use BondarDe\FilamentRouteList\Models\LaravelRoute;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ListLaravelRoutes extends ListRecords
{
    protected static string $resource = LaravelRouteResource::class;

    public function getTabs(): array
    {
        $allRoutes = LaravelRoute::all();

        $methods = $allRoutes
            ->groupBy('methods')
            ->map(fn (Collection $routes) => $routes->count())
            ->sortDesc();

        return [
            'all' => Tab::make()
                ->badge($allRoutes->count()),

            ...$methods->mapWithKeys(fn (int $count, string $method) => [
                $method => Tab::make($method)
                    ->badge($count)
                    ->badgeColor(FilamentRouteList::$methodColors[$method] ?? null)
                    ->modifyQueryUsing(
                        fn (Builder $query) => $query
                            ->where('methods', 'LIKE', "%\"$method\"%")
                    ),
            ]),
        ];
    }
}
