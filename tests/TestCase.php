<?php

namespace Vskstudio\Takt\Laravel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Vskstudio\Takt\Laravel\TaktServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [TaktServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('takt.domain', 'example.com');
        $app['config']->set('takt.endpoint', 'https://takt.example.com');
        $app['config']->set('takt.api_key', 'k_test');
        $app['config']->set('takt.mode', 'cdn');
    }
}
