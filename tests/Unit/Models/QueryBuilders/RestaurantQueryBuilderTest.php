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
}
