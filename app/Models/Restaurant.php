<?php

namespace App\Models;

use App\Models\Concerns\UnguardsAttributes;
use App\Models\QueryBuilders\RestaurantQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;
    use UnguardsAttributes;

    /**
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return RestaurantQueryBuilder<Restaurant>
     */
    public function newEloquentBuilder($query): RestaurantQueryBuilder
    {
        return new RestaurantQueryBuilder($query);
    }

    public function getStatusAttribute(): string
    {
        return $this->currentWeekdaySchedule->isOpen()
            ? 'Open'
            : 'Closed';
    }

    public function getStatusColorAttribute(): string
    {
        return $this->currentWeekdaySchedule->isOpen()
            ? 'green'
            : 'red';
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function currentWeekdaySchedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
