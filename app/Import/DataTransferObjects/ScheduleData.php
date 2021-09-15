<?php

namespace App\Import\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleData extends DataTransferObject
{
    public int $weekday;

    public string $open;

    public string $close;
}
