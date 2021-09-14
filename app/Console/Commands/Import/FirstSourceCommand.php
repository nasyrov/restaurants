<?php

namespace App\Console\Commands\Import;

use App\DataTransferObjects\Import\RestaurantData;
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
            $restaurantData = RestaurantData::fromRecordWithHeader($record);

            /** @var Restaurant $restaurant */
            $restaurant = Restaurant::firstOrCreate($restaurantData->only('name')->toArray());

            foreach ($restaurantData->schedules as $scheduleData) {
                Schedule::updateOrCreate(
                    ['restaurant_id' => $restaurant->id, 'weekday' => $scheduleData->weekday],
                    $scheduleData->only('open', 'close')->toArray()
                );
            }
        }

        $this->info('First source done.');

        return 0;
    }
}
