<?php

namespace App\DataTransferObjects\Import;

use Spatie\DataTransferObject\DataTransferObject;

class RestaurantData extends DataTransferObject
{
    public string $name;

    public static function fromRecordWithHeader(array $record): self
    {
        return new self([
            'name' => $record['Restaurant name'],
        ]);
    }

    public static function fromRecordWithoutHeader(array $record): self
    {
        return new self([
            'name' => $record[0],
        ]);
    }
}
