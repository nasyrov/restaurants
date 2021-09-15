<?php

namespace App\Models;

use App\Models\Concerns\UnguardsAttributes;
use App\Models\QueryBuilders\ScheduleQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;
    use UnguardsAttributes;

    /**
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return ScheduleQueryBuilder<Schedule>
     */
    public function newEloquentBuilder($query): ScheduleQueryBuilder
    {
        return new ScheduleQueryBuilder($query);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
