<?php

namespace App\Models\Concerns;

trait UnguardsAttributes
{
    public function getGuarded(): array
    {
        return [];
    }
}
