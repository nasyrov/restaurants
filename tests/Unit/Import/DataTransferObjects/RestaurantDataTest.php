<?php

namespace Tests\Unit\Import\DataTransferObjects;

use App\Import\DataTransferObjects\RestaurantData;
use Tests\TestCase;

class RestaurantDataTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_instance_from_record_with_header(): void
    {
        $data = RestaurantData::fromRecordWithHeader([
            'Restaurant name' => $name = $this->faker->company,
            'Opens'           => $this->faker->time,
            'Closes'          => $this->faker->time,
            'Days Open'       => 'Mo,Tu',
        ]);

        $this->assertInstanceOf(RestaurantData::class, $data);

        $this->assertSame($name, $data->name);
    }

    /** @test */
    public function it_creates_a_new_instance_from_record_without_header(): void
    {
        $data = RestaurantData::fromRecordWithoutHeader([
            0 => $name = $this->faker->company,
            1 => 'Mon-Thu, Sun 11:30 am - 9 pm  / Fri-Sat 11:30 am - 10 pm',
        ]);

        $this->assertInstanceOf(RestaurantData::class, $data);

        $this->assertSame($name, $data->name);
    }
}
