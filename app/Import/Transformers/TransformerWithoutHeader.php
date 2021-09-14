<?php

namespace App\Import\Transformers;

use App\DataTransferObjects\Import\RestaurantData;
use App\Import\Contracts\Transformable;
use Generator;
use League\Csv\Reader;

class TransformerWithoutHeader implements Transformable
{
    public function transform(Reader $reader): Generator
    {
        foreach ($reader as $record) {
            yield RestaurantData::fromRecordWithoutHeader($record);
        }
    }
}
