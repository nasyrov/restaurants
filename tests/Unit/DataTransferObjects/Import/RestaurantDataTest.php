<?php

namespace Tests\Unit\DataTransferObjects\Import;

use App\DataTransferObjects\Import\RestaurantData;
use Tests\TestCase;

class RestaurantDataTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_instance_from_first_source_record(): void
    {
        $data = RestaurantData::fromFirstSourceRecord([
            'Restaurant name' => $name = $this->faker->company,
        ]);

        $this->assertInstanceOf(RestaurantData::class, $data);
    }

    /** @test */
    public function it_creates_a_new_instance_from_second_source_record(): void
    {
        $data = RestaurantData::fromSecondSourceRecord([
            0 => $name = $this->faker->company,
        ]);

        $this->assertInstanceOf(RestaurantData::class, $data);
    }
}
