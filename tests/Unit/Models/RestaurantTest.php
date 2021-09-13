<?php

namespace Tests\Unit\Models;

use App\Models\Concerns\UnguardsAttributes;
use App\Models\Restaurant;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    /** @test */
    public function it_uses_unguard_attributes_concern(): void
    {
        $this->assertArrayHasKey(UnguardsAttributes::class, class_uses(Restaurant::class));
    }
}
