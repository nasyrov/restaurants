<?php

namespace Tests\Unit\Models\Concerns;

use App\Models\Concerns\UnguardsAttributes;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class UnguardsAttributesTest extends TestCase
{
    /** @test */
    public function it_empties_guarded_attributes(): void
    {
        $model = new class extends Model {
            use UnguardsAttributes;
        };

        $this->assertEmpty($model->getGuarded());
    }
}
