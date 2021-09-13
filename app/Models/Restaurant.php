<?php

namespace App\Models;

use App\Models\Concerns\UnguardsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    use UnguardsAttributes;
}
