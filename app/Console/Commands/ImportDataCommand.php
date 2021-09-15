<?php

namespace App\Console\Commands;

use App\Import\Transformers\TransformerContext;
use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

use function Safe\sprintf as sprintf;

class ImportDataCommand extends Command
{
    protected $signature = 'data:import {file : The file name} {--H|with-header : Whether the file contains header}';

    protected $description = 'Import data';

    public function handle(TransformerContext $transformerContext): int
    {
        $path = storage_path(sprintf('app/csv/%s', $this->argument('file')));

        $withHeader = $this->option('with-header');

        try {
            $reader = Reader::createFromPath($path)
                ->setHeaderOffset($withHeader ? 0 : null);
        } catch (UnavailableStream $e) {
            $this->error('Sorry, file does not exist.');

            return 1;
        }

        $records = $transformerContext
            ->determine($withHeader)
            ->transform($reader);

        foreach ($records as $restaurantData) {
            /** @var Restaurant $restaurant */
            $restaurant = Restaurant::firstOrCreate($restaurantData->only('name')->toArray());

            foreach ($restaurantData->schedules as $scheduleData) {
                Schedule::updateOrCreate(
                    ['restaurant_id' => $restaurant->id, 'weekday' => $scheduleData->weekday],
                    $scheduleData->only('open', 'close')->toArray()
                );
            }
        }

        $this->info('Done.');

        return 0;
    }
}
