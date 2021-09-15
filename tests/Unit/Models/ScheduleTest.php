<?php

namespace Tests\Unit\Models;

use App\Models\Concerns\UnguardsAttributes;
use App\Models\QueryBuilders\ScheduleQueryBuilder;
use App\Models\Restaurant;
use App\Models\Schedule;
use Carbon\Carbon;
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
    public function it_checks_whether_it_is_currently_open(): void
    {
        Carbon::setTestNow(Carbon::parse('10:05:00'));

        $schedule1 = new Schedule([
            'open'  => '10:00:00',
            'close' => '11:00:00',
        ]);

        $schedule2 = new Schedule([
            'open'  => '10:00:00',
            'close' => '01:00:00',
        ]);

        $schedule3 = new Schedule([
            'open'  => '11:00:00',
            'close' => '12:00:00',
        ]);

        $schedule4 = new Schedule([
            'open'  => '11:00:00',
            'close' => '02:00:00',
        ]);

        $this->assertTrue($schedule1->isOpen());
        $this->assertTrue($schedule2->isOpen());
        $this->assertFalse($schedule3->isOpen());
        $this->assertFalse($schedule4->isOpen());
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
