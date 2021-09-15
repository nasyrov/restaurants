<?php

namespace App\Import\DataTransferObjects;

use App\Import\Enums\ThreeLettersWeekdayEnum;
use App\Import\Enums\TwoLettersWeekdayEnum;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Spatie\DataTransferObject\DataTransferObjectCollection;

use function Safe\preg_match as preg_match;

/**
 * @method ScheduleData current()
 */
class ScheduleDataCollection extends DataTransferObjectCollection
{
    public static function fromFaker(Faker $faker): self
    {
        return new self([
            new ScheduleData([
                'weekday' => $faker->randomElement(range(1, 7)),
                'open'    => $faker->time,
                'close'   => $faker->time,
            ]),
        ]);
    }

    public static function fromRecordWithHeader(array $record): self
    {
        $weekdays = explode(',', $record['Days Open']);

        $transformer = fn(string $weekday): ScheduleData => new ScheduleData([
            'weekday' => TwoLettersWeekdayEnum::from($weekday)->value,
            'open'    => $record['Opens'],
            'close'   => $record['Closes'],
        ]);

        return new self(array_map($transformer, $weekdays));
    }

    public static function fromRecordWithoutHeader(array $record): self
    {
        $parts = explode('/', $record[1]);
        $parts = array_map('trim', $parts);

        $parseDays = function (string $days): array {
            if (!str_contains($days, '-')) {
                return [ThreeLettersWeekdayEnum::from($days)->value];
            }

            [$start, $end] = explode('-', $days, 2);

            $start = ThreeLettersWeekdayEnum::from($start)->value;
            $end   = ThreeLettersWeekdayEnum::from($end)->value;

            return range($start, $end);
        };

        $parseTime = fn(string $time): string => Carbon::createFromFormat(
            str_contains($time, ':') ? 'H:i a' : 'H a',
            $time
        )->format('H:i:s');

        $collection = [];

        foreach ($parts as $part) {
            preg_match('/^([^0-9]+)(?:([^-]*)[-\s]+(.*))$/i', $part, $matches);

            $matches = array_map('trim', $matches);

            $days = explode(',', $matches[1]);
            $days = array_map('trim', $days);
            $days = array_map($parseDays, $days);
            $days = array_merge(...$days);

            $openTime  = $parseTime($matches[2]);
            $closeTime = $parseTime($matches[3]);

            foreach ($days as $day) {
                $collection[] = new ScheduleData([
                    'weekday' => $day,
                    'open'    => $openTime,
                    'close'   => $closeTime,
                ]);
            }
        }

        return new self($collection);
    }
}
