<?php

namespace Tests\Unit\DataTransferObjects\Import;

use App\DataTransferObjects\Import\ScheduleDataCollection;
use Tests\TestCase;

class ScheduleDataCollectionTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_instance_from_record_with_header(): void
    {
        $collection = ScheduleDataCollection::fromRecordWithHeader([
            'Opens'     => $open = $this->faker->time,
            'Closes'    => $close = $this->faker->time,
            'Days Open' => 'Mo,Tu',
        ]);

        $this->assertInstanceOf(ScheduleDataCollection::class, $collection);

        $this->assertCount(
            2,
            array_filter(
                $collection->toArray(),
                fn(array $data) => $data['open'] === $open
            )
        );
        $this->assertCount(
            2,
            array_filter(
                $collection->toArray(),
                fn(array $data) => $data['close'] === $close
            )
        );
        $this->assertCount(
            2,
            array_filter(
                $collection->toArray(),
                fn(array $data) => in_array($data['weekday'], [1, 2], true)
            )
        );
    }

    /** @test */
    public function it_creates_a_new_instance_from_record_without_header(): void
    {
        $collection = ScheduleDataCollection::fromRecordWithoutHeader([
            1 => 'Mon-Thu, Sun 11:30 am - 9 pm  / Fri-Sat 11:30 am - 10 pm',
        ]);

        $this->assertInstanceOf(ScheduleDataCollection::class, $collection);

        $this->assertCount(
            7,
            array_filter(
                $collection->toArray(),
                fn(array $data) => $data['open'] === '11:30:00'
            )
        );
        $this->assertCount(
            5,
            array_filter(
                $collection->toArray(),
                fn(array $data) => $data['close'] === '21:00:00'
            )
        );
        $this->assertCount(
            2,
            array_filter(
                $collection->toArray(),
                fn(array $data) => $data['close'] === '22:00:00'
            )
        );
        $this->assertCount(
            7,
            array_filter(
                $collection->toArray(),
                fn(array $data) => in_array($data['weekday'], [1, 2, 3, 4, 5, 6, 7], true)
            )
        );
    }
}
