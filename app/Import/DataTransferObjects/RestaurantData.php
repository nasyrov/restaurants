<?php

namespace App\Import\DataTransferObjects;

use Faker\Generator as Faker;
use Spatie\DataTransferObject\DataTransferObject;

class RestaurantData extends DataTransferObject
{
    public string $name;

    public ScheduleDataCollection $schedules;

    public static function fromFaker(Faker $faker): self
    {
        return new self([
            'name'      => $faker->company,
            'schedules' => ScheduleDataCollection::fromFaker($faker),
        ]);
    }

    public static function fromRecordWithHeader(array $record): self
    {
        return new self([
            'name'      => $record['Restaurant name'],
            'schedules' => ScheduleDataCollection::fromRecordWithHeader($record),
        ]);
    }

    public static function fromRecordWithoutHeader(array $record): self
    {
        return new self([
            'name'      => $record[0],
            'schedules' => ScheduleDataCollection::fromRecordWithoutHeader($record),
        ]);
    }
}
