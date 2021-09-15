<?php

namespace Tests\Unit\Models\QueryBuilders;

use App\Models\Restaurant;
use App\Models\Schedule;
use Carbon\Carbon;
use Tests\TestCase;

class RestaurantQueryBuilderTest extends TestCase
{
    /** @test */
    public function it_scopes_query_to_include_restaurants_with_current_weekday_schedule(): void
    {
        Carbon::setTestNow(Carbon::parse('14-09-2021'));

        $restaurant1 = Restaurant::factory()
            ->create();

        $schedule1 = Schedule::factory()
            ->create([
                'restaurant_id' => $restaurant1->id,
                'weekday'       => 2,
            ]);

        $schedule2 = Schedule::factory()
            ->create([
                'restaurant_id' => $restaurant1->id,
                'weekday'       => 3,
            ]);

        $restaurant2 = Restaurant::factory()
            ->create();

        $schedule3 = Schedule::factory()
            ->create([
                'restaurant_id' => $restaurant2->id,
                'weekday'       => 3,
            ]);

        $restaurants = Restaurant::query()
            ->withCurrentWeekdaySchedule()
            ->latest()
            ->get();

        $this->assertTrue($restaurants->contains($restaurant1));
        $this->assertTrue($schedule1->is($restaurants->get(0)->currentWeekdaySchedule));

        $this->assertTrue($restaurants->contains($restaurant2));
        $this->assertNull($restaurants->get(1)->currentWeekdaySchedule);
    }

    /** @test */
    public function it_scopes_query_to_include_currently_opened_restaurants(): void
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
                'weekday'       => 2,
                'open'          => '11:00:00',
                'close'         => '12:00:00',
            ]);

        $restaurant3 = Restaurant::factory()
            ->create();

        $schedule3 = Schedule::factory()
            ->create([
                'restaurant_id' => $restaurant3->id,
                'weekday'       => 2,
                'open'          => '10:00:00',
                'close'         => '01:00:00',
            ]);

        $restaurants = Restaurant::query()
            ->currentlyOpened()
            ->get();

        $this->assertTrue($restaurants->contains($restaurant1));
        $this->assertFalse($restaurants->contains($restaurant2));
        $this->assertTrue($restaurants->contains($restaurant3));
    }

    /** @test */
    public function it_scopes_query_to_include_searched_restaurants(): void
    {
        $restaurant1 = Restaurant::factory()
            ->create([
                'name' => 'foo',
            ]);

        $restaurant2 = Restaurant::factory()
            ->create([
                'name' => 'bar',
            ]);

        $restaurants = Restaurant::query()
            ->search('oo')
            ->get();

        $this->assertTrue($restaurants->contains($restaurant1));
        $this->assertFalse($restaurants->contains($restaurant2));
    }
}
