<?php

namespace Tests\Unit\DataTransferObjects\Import;

use App\DataTransferObjects\Import\RestaurantData;
use Tests\TestCase;

class RestaurantDataTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_instance_from_record_with_header(): void
    {
        $data = RestaurantData::fromRecordWithHeader([
            'Restaurant name' => $name = $this->faker->company,
        ]);

        $this->assertInstanceOf(RestaurantData::class, $data);

        $this->assertSame($name, $data->name);
    }

    /** @test */
    public function it_creates_a_new_instance_from_record_without_header(): void
    {
        $data = RestaurantData::fromRecordWithoutHeader([
            0 => $name = $this->faker->company,
        ]);

        $this->assertInstanceOf(RestaurantData::class, $data);

        $this->assertSame($name, $data->name);
    }
}
