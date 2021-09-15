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
        Carbon::setTestNow(Carbon::parse('14-09-2021'));

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

    /** @test */
    public function it_scopes_query_to_include_schedules_status(): void
    {
        Carbon::setTestNow(Carbon::parse('10:05:00'));

        $schedule1 = Schedule::factory()
            ->create([
                'open'  => '10:00:00',
                'close' => '11:00:00',
            ]);

        $schedule2 = Schedule::factory()
            ->create([
                'open'  => '11:00:00',
                'close' => '12:00:00',
            ]);

        $schedules = Schedule::query()
            ->withCurrentStatus()
            ->latest()
            ->get();

        $this->assertSame('open', $schedules->get(0)->status);
        $this->assertSame('closed', $schedules->get(1)->status);
    }

    /** @test */
    public function it_scopes_query_to_include_schedules_within_working_hours(): void
    {
        Carbon::setTestNow(Carbon::parse('10:05:00'));

        $schedule1 = Schedule::factory()
            ->create([
                'open'  => '10:00:00',
                'close' => '11:00:00',
            ]);

        $schedule2 = Schedule::factory()
            ->create([
                'open'  => '10:00:00',
                'close' => '01:00:00',
            ]);

        $schedule3 = Schedule::factory()
            ->create([
                'open'  => '11:00:00',
                'close' => '12:00:00',
            ]);

        $schedule4 = Schedule::factory()
            ->create([
                'open'  => '11:00:00',
                'close' => '02:00:00',
            ]);

        $schedules = Schedule::query()
            ->withinWorkingHours()
            ->get();

        $this->assertTrue($schedules->contains($schedule1));
        $this->assertTrue($schedules->contains($schedule2));
        $this->assertFalse($schedules->contains($schedule3));
        $this->assertFalse($schedules->contains($schedule4));
    }
}
