<?php

namespace Tests\Unit\Models;

use App\Models\Concerns\UnguardsAttributes;
use App\Models\QueryBuilders\ScheduleQueryBuilder;
use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    /** @test */
    public function it_uses_unguard_attributes_concern(): void
    {
        $this->assertArrayHasKey(UnguardsAttributes::class, class_uses(Restaurant::class));
    }

    /** @test */
    public function it_uses_custom_query_builder(): void
    {
        $this->assertInstanceOf(ScheduleQueryBuilder::class, Schedule::query());
    }

    /** @test */
    public function it_has_many_schedules(): void
    {
        $schedule = new Schedule();

        $restaurant = $schedule->restaurant();

        $this->assertInstanceOf(BelongsTo::class, $restaurant);
        $this->assertInstanceOf(Restaurant::class, $restaurant->getRelated());
    }
}
