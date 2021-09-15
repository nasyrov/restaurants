<?php

namespace App\Import\Contracts;

use Generator;
use League\Csv\Reader;

interface Transformable
{
    /**
     * @return Generator|\App\Import\DataTransferObjects\RestaurantData[]
     */
    public function transform(Reader $reader): Generator;
}
