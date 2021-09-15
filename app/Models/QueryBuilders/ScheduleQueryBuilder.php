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

    public function withCurrentStatus(): self
    {
        $function = config('database.default') === 'sqlite' ? 'IIF' : 'IF';

        return $this->selectRaw(
            \Safe\sprintf("%s(? BETWEEN open AND close, 'open', 'closed') as status", $function),
            [now()->format('H:i:s')]
        );
    }

    public function withinOpeningHours(): self
    {
        return $this->whereRaw('? BETWEEN open AND close', [now()->format('H:i:s')]);
    }
}
