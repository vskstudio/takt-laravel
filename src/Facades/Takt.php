<?php

namespace Vskstudio\Takt\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void event(string $name, array $props = [], ?\Vskstudio\Takt\Revenue $revenue = null, ?string $url = null)
 * @method static void pageview(?string $url = null)
 */
final class Takt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Vskstudio\Takt\Takt::class;
    }
}
