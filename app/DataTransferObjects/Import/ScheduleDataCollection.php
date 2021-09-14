<?php

namespace App\DataTransferObjects\Import;

use App\Enums\Import\ThreeLettersWeekdayEnum;
use App\Enums\Import\TwoLettersWeekdayEnum;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * @method ScheduleData current()
 */
class ScheduleDataCollection extends DataTransferObjectCollection
{
    public static function fromFirstSourceRecord(array $record): self
    {
        $weekdays = explode(',', $record['Days Open']);

        $transformer = fn(string $weekday): ScheduleData => new ScheduleData([
            'weekday'    => TwoLettersWeekdayEnum::from($weekday)->value,
            'start_hour' => $record['Opens'],
            'end_hour'   => $record['Closes'],
        ]);

        return new self(array_map($transformer, $weekdays));
    }

    public static function fromSecondSourceRecord(array $record): self
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

            $startHour = $parseTime($matches[2]);
            $endHour   = $parseTime($matches[3]);

            foreach ($days as $day) {
                $collection[] = new ScheduleData([
                    'weekday'    => $day,
                    'start_hour' => $startHour,
                    'end_hour'   => $endHour,
                ]);
            }
        }

        return new self($collection);
    }
}
