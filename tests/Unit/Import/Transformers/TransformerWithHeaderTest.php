<?php

namespace Tests\Unit\Import\Transformers;

use App\DataTransferObjects\Import\RestaurantData;
use App\Import\Transformers\TransformerWithHeader;
use League\Csv\Reader;
use Tests\TestCase;

class TransformerWithHeaderTest extends TestCase
{
    /** @test */
    public function it_transforms_reader_records_with_header(): void
    {
        $source = <<<EOF
        Restaurant name,Opens,Closes,Days Open
        Angular Pizza,6:00:00,0:00:00,"Mo,Tu,We,Th,Fr,Sa,Su"
        EOF;

        $reader = Reader::createFromString($source)
            ->setHeaderOffset(0);

        $transformer = new TransformerWithHeader();
        $records     = $transformer->transform($reader);

        $record = $records->current();

        $this->assertCount(1, $records);
        $this->assertInstanceOf(RestaurantData::class, $record);
    }
}
