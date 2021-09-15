<?php

namespace Tests\Feature\Console;

use App\Console\Commands\ImportDataCommand;
use App\Import\Contracts\Transformable;
use App\Import\DataTransferObjects\RestaurantData;
use App\Import\Transformers\TransformerContext;
use League\Csv\Reader;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ImportDataCommandTest extends TestCase
{
    /** @test */
    public function it_outputs_error_whenever_file_does_not_exist(): void
    {
        $this
            ->artisan(ImportDataCommand::class, ['file' => 'test.csv'])
            ->expectsOutput('Sorry, file does not exist.')
            ->assertExitCode(1);
    }

    /** @test */
    public function it_imports_data_with_header(): void
    {
        $restaurantData = RestaurantData::fromFaker($this->faker);
        $scheduleData   = $restaurantData->schedules->current();

        $transformer = Mockery::mock(Transformable::class);
        $transformer
            ->shouldReceive('transform')
            ->with(Reader::class)
            ->andYield($restaurantData);

        $this->mock(
            TransformerContext::class,
            function (MockInterface $mock) use ($transformer) {
                $mock
                    ->shouldReceive('determine')
                    ->with(true)
                    ->andReturn($transformer);
            }
        );

        $this
            ->artisan(ImportDataCommand::class, ['file' => 'restaurants-hours-source-1.csv', '--with-header' => true])
            ->expectsOutput('Done.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('restaurants', $restaurantData->only('name')->toArray());
        $this->assertDatabaseHas('schedules', $scheduleData->toArray());
    }

    /** @test */
    public function it_imports_data_without_header(): void
    {
        $restaurantData = RestaurantData::fromFaker($this->faker);
        $scheduleData   = $restaurantData->schedules->current();

        $transformer = Mockery::mock(Transformable::class);
        $transformer
            ->shouldReceive('transform')
            ->with(Reader::class)
            ->andYield($restaurantData);

        $this->mock(
            TransformerContext::class,
            function (MockInterface $mock) use ($transformer) {
                $mock
                    ->shouldReceive('determine')
                    ->with(false)
                    ->andReturn($transformer);
            }
        );

        $this
            ->artisan(ImportDataCommand::class, ['file' => 'restaurants-hours-source-2.csv'])
            ->expectsOutput('Done.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('restaurants', $restaurantData->only('name')->toArray());
        $this->assertDatabaseHas('schedules', $scheduleData->toArray());
    }
}
