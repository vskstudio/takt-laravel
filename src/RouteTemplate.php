<?php

namespace Vskstudio\Takt\Laravel;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

final class RouteTemplate
{
    public static function of(?Request $request): ?string
    {
        $route = $request?->route();

        return $route instanceof Route ? '/'.ltrim($route->uri(), '/') : null;
    }
}
