<?php

namespace Vskstudio\Takt\Laravel\Tests;

use Illuminate\Support\ServiceProvider;
use Vskstudio\Takt\Laravel\TaktServiceProvider;
use Vskstudio\Takt\SnippetRenderer;
use Vskstudio\Takt\Takt;

final class ServiceProviderTest extends TestCase
{
    public function test_takt_resolves_as_singleton(): void
    {
        $a = $this->app->make(Takt::class);
        $b = $this->app->make(Takt::class);

        $this->assertInstanceOf(Takt::class, $a);
        $this->assertSame($a, $b);
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
