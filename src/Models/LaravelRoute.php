<?php

namespace BondarDe\FilamentRouteList\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Sushi\Sushi;

/**
 * @property string $name
 * @property array $action
 * @property array $defaults
 * @property array $methods
 * @property array $wheres
 */
class LaravelRoute extends Model
{
    use Sushi;

    public function getRows()
    {
        $router = app(Router::class);
        $routes = collect($router->getRoutes()->getRoutes())
            ->sortBy('uri');

        return $routes
            ->map(function (Route $route) {
                $data = (array) $route;

                $data = Arr::only($data, [
                    'uri',
                    'methods',
                    'action',
                    'isFallback',
                    'defaults',
                    'wheres',
                ]);

                return [
                    ...array_map(fn ($val) => match (gettype($val)) {
                        'NULL',
                        'boolean',
                        'string' => $val,

                        'object' => $val::class,

                        'array' => json_encode($val),
                    }, $data),
                    'name' => $data['action']['as'] ?? null,
                ];
            })
            ->toArray();
    }

    protected $casts = [
        'methods' => 'array',
        'action' => 'array',
        'wheres' => 'array',
        'defaults' => 'array',
    ];
}
