<?php

namespace Tests\Feature\Web;

use App\Http\Livewire\Restaurants;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function it_shows_home_page_that_contains_livewire_component(): void
    {
        $this
            ->withoutMix()
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('home')
            ->assertSeeLivewire(Restaurants::class);
    }
}
