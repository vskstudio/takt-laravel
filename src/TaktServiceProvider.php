<?php

namespace Vskstudio\Takt\Laravel;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Vskstudio\Takt\Options;
use Vskstudio\Takt\SnippetRenderer;
use Vskstudio\Takt\Takt;

final class TaktServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/takt.php', 'takt');

        $this->app->singleton(SnippetRenderer::class, function ($app) {
            $c = $app['config']['takt'];

            return new SnippetRenderer(Options::fromArray([
                'domain' => $c['domain'],
                'endpoint' => $c['endpoint'],
                'mode' => $c['mode'],
                'outbound' => $c['outbound'],
                'files' => $c['files'],
                'excludeLocalhost' => $c['exclude_localhost'],
            ]));
        });

        $this->app->singleton(Takt::class, function ($app) {
            $c = $app['config']['takt'];
            $takt = new Takt($c['endpoint'], $c['domain'], $c['api_key']);
            $request = $app['request'] ?? null;
            if ($request !== null) {
                $takt = $takt->withVisitor($request->ip(), $request->userAgent());
            }

            return $takt;
        });
    }

    public function boot(): void
    {
        $this->publishes([__DIR__.'/../config/takt.php' => config_path('takt.php')], 'takt-config');

        Blade::directive('takt', static function () {
            return '<?php echo app(\\Vskstudio\\Takt\\SnippetRenderer::class)->render(); ?>';
        });
    }
}
