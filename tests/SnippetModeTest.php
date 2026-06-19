<?php

namespace Vskstudio\Takt\Laravel\Tests;

use Vskstudio\Takt\SnippetRenderer;

final class SnippetModeTest extends TestCase
{
    private function renderWithMode(string $mode): string
    {
        $this->app['config']->set('takt.mode', $mode);
        $this->app->forgetInstance(SnippetRenderer::class);

        return $this->app->make(SnippetRenderer::class)->render();
    }

    public function test_inline_mode_embeds_bundle(): void
    {
        $html = $this->renderWithMode('inline');

        $this->assertStringContainsString('var takt=', $html);
        $this->assertStringNotContainsString('src=', $html);
        $this->assertStringContainsString('data-domain="example.com"', $html);
    }

    public function test_cdn_mode_uses_jsdelivr(): void
    {
        $html = $this->renderWithMode('cdn');

        $this->assertStringContainsString('cdn.jsdelivr.net', $html);
        $this->assertStringContainsString('src="https://cdn.jsdelivr.net', $html);
        $this->assertStringContainsString('data-domain="example.com"', $html);
    }

    public function test_asset_mode_uses_local_path(): void
    {
        $html = $this->renderWithMode('asset');

        $this->assertStringContainsString('src="/takt/takt.auto.js"', $html);
        $this->assertStringContainsString('data-domain="example.com"', $html);
    }

    public function test_autocapture_config_drives_data_auto(): void
    {
        $this->app['config']->set('takt.mode', 'cdn');
        $this->app['config']->set('takt.outbound', true);
        $this->app['config']->set('takt.files', true);
        $this->app['config']->set('takt.tagged', true);
        $this->app['config']->set('takt.not_found', true);
        $this->app['config']->set('takt.file_extensions', ['pdf', 'zip']);
        $this->app->forgetInstance(SnippetRenderer::class);

        $html = $this->app->make(SnippetRenderer::class)->render();

        $this->assertStringContainsString('data-auto="outbound,downloads,tagged,404"', $html);
        $this->assertStringContainsString('data-downloads-ext="pdf,zip"', $html);
    }
}
