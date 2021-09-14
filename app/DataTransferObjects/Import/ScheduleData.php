<?php

namespace App\DataTransferObjects\Import;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleData extends DataTransferObject
{
    public int $weekday;

    public string $open;

    public string $close;
}
