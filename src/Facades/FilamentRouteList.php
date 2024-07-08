<?php

namespace BondarDe\FilamentRouteList\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BondarDe\FilamentRouteList\FilamentRouteList
 */
class FilamentRouteList extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BondarDe\FilamentRouteList\FilamentRouteList::class;
    }
}
