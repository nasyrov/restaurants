<?php

namespace Tests\Feature\Web;

use App\Http\Livewire\Restaurants;
use App\Models\Restaurant;
use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class RestaurantsTest extends TestCase
{
    /** @test */
    public function it_shows_currently_open_restaurants(): void
    {
        Carbon::setTestNow(Carbon::parse('14-09-2021 10:05:00'));

        $restaurant1 = Restaurant::factory()
            ->create();

        $schedule1 = Schedule::factory()
            ->create([
                'restaurant_id' => $restaurant1->id,
                'weekday'       => 2,
                'open'          => '10:00:00',
                'close'         => '11:00:00',
            ]);

        $restaurant2 = Restaurant::factory()
            ->create();

        $schedule2 = Schedule::factory()
            ->create([
                'restaurant_id' => $restaurant2->id,
                'weekday'       => 3,
                'open'          => '10:00:00',
                'close'         => '11:00:00',
            ]);

        Livewire::test(Restaurants::class)
            ->assertViewIs('livewire.restaurants')
            ->assertSee($restaurant1->name)
            ->assertDontSee($restaurant2->name);
    }
}
