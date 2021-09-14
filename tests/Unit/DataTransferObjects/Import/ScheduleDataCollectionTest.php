<?php

namespace Tests\Unit\DataTransferObjects\Import;

use App\DataTransferObjects\Import\ScheduleDataCollection;
use Tests\TestCase;

class ScheduleDataCollectionTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_instance_from_first_source_record(): void
    {
        $collection = ScheduleDataCollection::fromFirstSourceRecord([
            'Opens'     => $this->faker->time,
            'Closes'    => $this->faker->time,
            'Days Open' => 'Mo,Tu,We,Th,Fr,Sa,Su',
        ]);

        $this->assertInstanceOf(ScheduleDataCollection::class, $collection);
    }

    /** @test */
    public function it_creates_a_new_instance_from_second_source_record(): void
    {
        $collection = ScheduleDataCollection::fromSecondSourceRecord([
            1 => 'Mon-Wed 5 pm - 12:30 am  / Thu-Fri 5 pm - 1:30 am  / Sat 3 pm - 1:30 am  / Sun 3 pm - 11:30 pm',
        ]);

        $this->assertInstanceOf(ScheduleDataCollection::class, $collection);
    }
}
