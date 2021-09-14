<?php

namespace App\Console\Commands\Import;

use App\DataTransferObjects\Import\RestaurantData;
use App\DataTransferObjects\Import\ScheduleDataCollection;
use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Console\Command;
use League\Csv\Reader;

class FirstSourceCommand extends Command
{
    protected $signature = 'import:first-source';

    protected $description = 'Import first source';

    public function handle(): int
    {
        $reader = Reader::createFromPath(storage_path('app/csv/restaurants-hours-source-1.csv'))
            ->setHeaderOffset(0);

        foreach ($reader as $record) {
            $restaurantData         = RestaurantData::fromFirstSourceRecord($record);
            $scheduleDataCollection = ScheduleDataCollection::fromFirstSourceRecord($record);

            /** @var Restaurant $restaurant */
            $restaurant = Restaurant::firstOrCreate($restaurantData->toArray());

            foreach ($scheduleDataCollection as $scheduleData) {
                Schedule::updateOrCreate(
                    ['restaurant_id' => $restaurant->id, 'weekday' => $scheduleData->weekday],
                    ['start_hour' => $scheduleData->start_hour, 'end_hour' => $scheduleData->end_hour]
                );
            }
        }

        $this->info('First source done.');

        return 0;
    }
}
