<?php

namespace App\DataTransferObjects\Import;

use Spatie\DataTransferObject\DataTransferObject;

class RestaurantData extends DataTransferObject
{
    public string $name;

    public static function fromFirstSourceRecord(array $record): self
    {
        return new self([
            'name' => $record['Restaurant name'],
        ]);
    }
}
