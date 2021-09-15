<?php

namespace Tests\Feature\Web;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function it_shows_home_page(): void
    {
        $this
            ->withoutMix()
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('welcome');
    }
}
