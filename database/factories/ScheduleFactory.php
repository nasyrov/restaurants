<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'restaurant_id' => Restaurant::factory(),
            'weekday'       => date('N', $this->faker->unixTime),
            'start_hour'    => $this->faker->time,
            'end_hour'      => $this->faker->time,
        ];
    }
}
