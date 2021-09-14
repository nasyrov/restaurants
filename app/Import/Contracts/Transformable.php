<?php

namespace App\Import\Contracts;

use Generator;
use League\Csv\Reader;

interface Transformable
{
    public function transform(Reader $reader): Generator;
}
