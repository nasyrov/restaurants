<?php

namespace Tests\Unit\Import\Transformers;

use App\DataTransferObjects\Import\RestaurantData;
use App\Import\Contracts\Transformable;
use App\Import\Transformers\TransformerWithoutHeader;
use League\Csv\Reader;
use Tests\TestCase;

class TransformerWithoutHeaderTest extends TestCase
{
    /** @test */
    public function it_implements_transformable_contact(): void
    {
        $transformer = new TransformerWithoutHeader();

        $this->assertInstanceOf(Transformable::class, $transformer);
    }

    /** @test */
    public function it_transforms_reader_records_with_header(): void
    {
        $source = <<<EOF
        "Hanuri","Mon-Sun 11 am - 12 am"
        EOF;

        $reader = Reader::createFromString($source);

        $transformer = new TransformerWithoutHeader();
        $records     = $transformer->transform($reader);

        $record = $records->current();

        $this->assertCount(1, $records);
        $this->assertInstanceOf(RestaurantData::class, $record);
    }
}
