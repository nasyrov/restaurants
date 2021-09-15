<?php

namespace App\Import\Transformers;

use App\Import\Contracts\Transformable;
use App\Import\DataTransferObjects\RestaurantData;
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
