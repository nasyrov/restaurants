<?php

namespace App\DataTransferObjects\Import;

use App\Enums\Import\TwoLettersWeekdayEnum;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * @method ScheduleData current
 */
class ScheduleDataCollection extends DataTransferObjectCollection
{
    public static function fromFirstSourceRecord(array $record): self
    {
        return new self(array_map(fn(string $weekday): ScheduleData => new ScheduleData([
            'weekday'    => TwoLettersWeekdayEnum::from($weekday)->value,
            'start_hour' => $record['Opens'],
            'end_hour'   => $record['Closes'],
        ]), explode(',', $record['Days Open'])));
    }
}
