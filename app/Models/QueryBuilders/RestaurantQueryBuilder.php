<?php

namespace App\Models\QueryBuilders;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \App\Models\Restaurant
 * @extends Builder<\App\Models\Restaurant>
 */
class RestaurantQueryBuilder extends Builder
{
    public function withCurrentWeekdaySchedule(): self
    {
        return $this
            ->addSelect([
                'current_weekday_schedule_id' => Schedule::query()
                    ->select('id')
                    ->whereColumn('restaurant_id', 'restaurants.id')
                    ->currentWeekday()
                    ->take(1),
            ])
            ->with('currentWeekdaySchedule');
    }

    public function currentlyOpened(): self
    {
        return $this->whereHas(
            'schedules',
            fn(ScheduleQueryBuilder $query) => $query
                ->currentWeekday()
                ->withinWorkingHours()
        );
    }
}
