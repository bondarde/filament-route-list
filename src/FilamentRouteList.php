<?php

namespace BondarDe\FilamentRouteList;

use Filament\Support\Colors\Color;

class FilamentRouteList
{
    public static array $methodColors = [
        'GET' => Color::Sky,
        'HEAD' => Color::Purple,
        'POST' => Color::Emerald,
        'PUT' => Color::Amber,
        'DELETE' => Color::Red,
        'OPTIONS' => Color::Blue,
        'PATCH' => Color::Teal,
    ];
}
