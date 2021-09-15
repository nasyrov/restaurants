<?php

namespace Tests\Unit\Models;

use App\Models\Concerns\UnguardsAttributes;
use App\Models\QueryBuilders\RestaurantQueryBuilder;
use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    /** @test */
    public function it_uses_unguard_attributes_concern(): void
    {
        $this->assertArrayHasKey(UnguardsAttributes::class, class_uses(Restaurant::class));
    }

    /** @test */
    public function it_uses_custom_query_builder(): void
    {
        $this->assertInstanceOf(RestaurantQueryBuilder::class, Restaurant::query());
    }

    /** @test */
    public function it_has_many_schedules(): void
    {
        $restaurant = new Restaurant();

        $schedules = $restaurant->schedules();

        $this->assertInstanceOf(HasMany::class, $schedules);
        $this->assertInstanceOf(Schedule::class, $schedules->getRelated());
    }

    /** @test */
    public function it_belongs_to_current_weekday_schedule(): void
    {
        $restaurant = new Restaurant();

        $currentWeekdaySchedule = $restaurant->currentWeekdaySchedule();

        $this->assertInstanceOf(BelongsTo::class, $currentWeekdaySchedule);
        $this->assertInstanceOf(Schedule::class, $currentWeekdaySchedule->getRelated());
    }
}
