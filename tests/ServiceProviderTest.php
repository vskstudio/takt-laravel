<?php

namespace Vskstudio\Takt\Laravel\Tests;

use Illuminate\Support\ServiceProvider;
use Vskstudio\Takt\Laravel\TaktServiceProvider;
use Vskstudio\Takt\SnippetRenderer;
use Vskstudio\Takt\Takt;

final class ServiceProviderTest extends TestCase
{
    public function test_takt_is_shared_within_a_request(): void
    {
        $a = $this->app->make(Takt::class);
        $b = $this->app->make(Takt::class);

        $this->assertInstanceOf(Takt::class, $a);
        $this->assertSame($a, $b);
    }

    public function test_takt_is_rebuilt_per_request_scope(): void
    {
        // Scoped, not singleton: visitor attribution is bound from the current
        // request, so a new request scope must yield a fresh instance instead of
        // reusing the first request's IP/user-agent (e.g. under Octane).
        $first = $this->app->make(Takt::class);
        $this->app->forgetScopedInstances();
        $second = $this->app->make(Takt::class);

        $this->assertNotSame($first, $second);
    }

    public function test_snippet_renderer_resolves_as_singleton(): void
    {
        $a = $this->app->make(SnippetRenderer::class);
        $b = $this->app->make(SnippetRenderer::class);

        $this->assertInstanceOf(SnippetRenderer::class, $a);
        $this->assertSame($a, $b);
    }

    public function test_takt_blade_directive_renders_snippet(): void
    {
        $rendered = (string) $this->blade('@takt');

        $this->assertStringContainsString('data-domain="example.com"', $rendered);
    }

    public function test_config_defaults_are_merged(): void
    {
        // Default endpoint comes from the package config file (env fallback).
        $this->assertSame('https://takt.example.com', config('takt.endpoint'));
        $this->assertTrue(config('takt.exclude_localhost'));
    }

    public function test_config_is_publishable_under_takt_config_tag(): void
    {
        $paths = ServiceProvider::pathsToPublish(TaktServiceProvider::class, 'takt-config');

        $this->assertNotEmpty($paths);
        $this->assertContains('takt.php', array_map('basename', array_keys($paths)));
    }
}
