<?php

namespace App\Console\Commands\Import;

use App\DataTransferObjects\Import\RestaurantData;
use App\DataTransferObjects\Import\ScheduleDataCollection;
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
            $restaurantData         = RestaurantData::fromSecondSourceRecord($record);
            $scheduleDataCollection = ScheduleDataCollection::fromSecondSourceRecord($record);

            /** @var Restaurant $restaurant */
            $restaurant = Restaurant::firstOrCreate($restaurantData->toArray());

            foreach ($scheduleDataCollection as $scheduleData) {
                Schedule::updateOrCreate(
                    ['restaurant_id' => $restaurant->id, 'weekday' => $scheduleData->weekday],
                    ['start_hour' => $scheduleData->start_hour, 'end_hour' => $scheduleData->end_hour]
                );
            }
        }

        $this->info('Second source done.');

        return 0;
    }
}
