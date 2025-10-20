<?php

namespace BondarDe\FilamentRouteList\Filament\Resources;

use BondarDe\FilamentRouteList\Filament\Resources\RouteResource\Pages;
use BondarDe\FilamentRouteList\FilamentRouteList;
use BondarDe\FilamentRouteList\Models\LaravelRoute;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class LaravelRouteResource extends Resource
{
    protected static ?string $model = LaravelRoute::class;

    protected static string | null | \BackedEnum $navigationIcon = Heroicon::OutlinedListBullet;

    protected static string | null | \UnitEnum $navigationGroup = 'System';

    protected static ?string $slug = 'system/laravel-routes';

    protected static ?string $label = 'Laravel Route';

    protected static ?string $pluralLabel = 'Laravel Routes';

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('uri')
                            ->label('URI')
                            ->weight(FontWeight::Bold)
                            ->copyable(),
                        TextEntry::make('name')
                            ->placeholder('n/a')
                            ->copyable(),
                        TextEntry::make('methods')
                            ->badge()
                            ->color(fn (string $state) => FilamentRouteList::$methodColors[$state] ?? null)
                            ->listWithLineBreaks(),
                        IconEntry::make('isFallback')
                            ->label('Fallback route')
                            ->boolean(),
                    ])
                    ->columns([
                        'md' => 2,
                    ]),
                KeyValueEntry::make('action')
                    ->state(fn ($record) => array_map(fn (mixed $val) => match (gettype($val)) {
                        'NULL',
                        'array' => json_encode($val, JSON_PRETTY_PRINT),
                        default => $val,
                    }, $record->action)),
                KeyValueEntry::make('wheres'),
                KeyValueEntry::make('defaults'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        $pre = fn (mixed $value): HtmlString => new HtmlString('<pre>' . json_encode($value, JSON_PRETTY_PRINT) . '</pre>');

        return $table
            ->recordClasses('align-top')
            ->columns([
                TextColumn::make('uri')
                    ->label('URI, Name')
                    ->weight(FontWeight::Bold)
                    ->description(fn ($record) => $record->name)
                    ->searchable([
                        'uri',
                        'name',
                    ])
                    ->sortable(),
                TextColumn::make('methods')
                    ->badge()
                    ->color(fn (string $state) => FilamentRouteList::$methodColors[$state] ?? null)
                    ->listWithLineBreaks()
                    ->searchable(),
                TextColumn::make('action')
                    ->state(fn (LaravelRoute $record) => $pre($record->action))
                    ->placeholder('n/a')
                    ->searchable(),
                TextColumn::make('wheres')
                    ->state(fn (LaravelRoute $record) => $record->wheres ? $pre($record->wheres) : null)
                    ->placeholder('n/a')
                    ->searchable(),
                TextColumn::make('defaults')
                    ->state(fn (LaravelRoute $record) => $record->defaults ? $pre($record->defaults) : null)
                    ->placeholder('n/a')
                    ->searchable(),
                IconColumn::make('isFallback')
                    ->label('Fallback')
                    ->boolean(),
            ])
            ->defaultSort('path');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaravelRoutes::route('/'),
            'view' => Pages\ViewLaravelRoute::route('/{record}'),
        ];
    }
}
