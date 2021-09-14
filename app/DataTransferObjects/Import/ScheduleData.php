<?php

namespace App\DataTransferObjects\Import;

use App\Enums\Import\TwoLettersWeekdayEnum;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleData extends DataTransferObject
{
    public int $weekday;

    public string $start_hour;

    public string $end_hour;
}
