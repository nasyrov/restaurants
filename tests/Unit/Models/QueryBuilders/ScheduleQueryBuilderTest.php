<?php

namespace Tests\Unit\Models\QueryBuilders;

use App\Models\Schedule;
use Carbon\Carbon;
use Tests\TestCase;

class ScheduleQueryBuilderTest extends TestCase
{
    /** @test */
    public function it_scopes_query_to_include_schedules_for_current_weekday(): void
    {
        Carbon::setTestNow(Carbon::parse('14.09.2021'));

        $schedule1 = Schedule::factory()
            ->create([
                'weekday' => 2,
            ]);

        $schedule2 = Schedule::factory()
            ->create([
                'weekday' => 3,
            ]);

        $schedules = Schedule::query()
            ->currentWeekday()
            ->get();

        $this->assertTrue($schedules->contains($schedule1));
        $this->assertFalse($schedules->contains($schedule2));
    }
}
