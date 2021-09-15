<?php

namespace Tests\Feature\Web;

use App\Http\Livewire\Restaurants;
use App\Models\Restaurant;
use Livewire\Livewire;
use Tests\TestCase;

class RestaurantsTest extends TestCase
{
    /** @test */
    public function it_shows_restaurants(): void
    {
        $restaurants = Restaurant::factory()
            ->count(2)
            ->create();

        Livewire::test(Restaurants::class)
            ->assertViewIs('livewire.restaurants')
            ->assertSee($restaurants->get(0)->name)
            ->assertSee($restaurants->get(1)->name);
    }
}
