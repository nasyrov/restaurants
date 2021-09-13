<?php

namespace App\Models;

use App\Models\Concerns\UnguardsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;
    use UnguardsAttributes;

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
