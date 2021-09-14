<?php

namespace Tests\Unit\Import\Transformers;

use App\Import\Transformers\TransformerContext;
use App\Import\Transformers\TransformerWithHeader;
use App\Import\Transformers\TransformerWithoutHeader;
use Tests\TestCase;

class TransformerContextTest extends TestCase
{
    /** @test */
    public function it_resolves_transformer_with_header(): void
    {
        $context     = new TransformerContext();
        $transformer = $context->determine($withHeader = true);

        $this->assertInstanceOf(TransformerWithHeader::class, $transformer);
    }

    /** @test */
    public function it_resolves_transformer_without_header(): void
    {
        $context     = new TransformerContext();
        $transformer = $context->determine($withHeader = false);

        $this->assertInstanceOf(TransformerWithoutHeader::class, $transformer);
    }
}
