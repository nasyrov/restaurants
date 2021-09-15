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
}
