<?php

namespace App\Import\Transformers;

use App\Import\Contracts\Transformable;

class TransformerContext
{
    public function determine(bool $withHeader): Transformable
    {
        if ($withHeader) {
            return new TransformerWithHeader();
        }

        return new TransformerWithoutHeader();
    }
}
