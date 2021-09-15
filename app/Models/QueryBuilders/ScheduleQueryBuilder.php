<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \App\Models\Schedule
 * @extends Builder<\App\Models\Schedule>
 */
class ScheduleQueryBuilder extends Builder
{
    public function currentWeekday(): self
    {
        return $this->where('weekday', now()->dayOfWeekIso);
    }

    public function withinWorkingHours(): self
    {
        $time = now()->format('H:i:s');

        return $this
            ->where(fn(Builder $query) => $query
                ->whereColumn('open', '<=', 'close')
                ->where(fn(Builder $query) => $query
                    ->where('open', '<=', $time)
                    ->where('close', '>=', $time)
                )
            )
            ->orWhere(fn(Builder $query) => $query
                ->whereColumn('open', '>=', 'close')
                ->where(fn(Builder $query) => $query
                    ->where('open', '<=', $time)
                    ->orWhere('close', '>=', $time)
                )
            );
    }
}
