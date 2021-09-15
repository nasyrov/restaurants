<?php

namespace App\Console\Commands\Import;

use App\Import\DataTransferObjects\RestaurantData;
use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Console\Command;
use League\Csv\Reader;

class SecondSourceCommand extends Command
{
    protected $signature = 'import:second-source';

    protected $description = 'Import second source';

    public function handle(): int
    {
        $reader = Reader::createFromPath(storage_path('app/csv/restaurants-hours-source-2.csv'));

        foreach ($reader as $record) {
            $restaurantData = RestaurantData::fromRecordWithoutHeader($record);

            /** @var Restaurant $restaurant */
            $restaurant = Restaurant::firstOrCreate($restaurantData->only('name')->toArray());

            foreach ($restaurantData->schedules as $scheduleData) {
                Schedule::updateOrCreate(
                    ['restaurant_id' => $restaurant->id, 'weekday' => $scheduleData->weekday],
                    $scheduleData->only('open', 'close')->toArray()
                );
            }
        }

        $this->info('Second source done.');

        return 0;
    }
}
