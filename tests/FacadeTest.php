<?php

namespace Vskstudio\Takt\Laravel\Tests;

use Vskstudio\Takt\Laravel\Facades\Takt as TaktFacade;
use Vskstudio\Takt\Takt;

final class FacadeTest extends TestCase
{
    public function test_facade_root_is_underlying_takt_singleton(): void
    {
        $root = TaktFacade::getFacadeRoot();

        $this->assertInstanceOf(Takt::class, $root);
        $this->assertSame($this->app->make(Takt::class), $root);
    }

    public function test_pageview_does_not_throw(): void
    {
        TaktFacade::pageview('/home');

        $this->expectNotToPerformAssertions();
    }

    public function test_event_does_not_throw(): void
    {
        TaktFacade::event('Signup', ['plan' => 'pro']);

        $this->expectNotToPerformAssertions();
    }
}
