<?php

namespace App\Import\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self Mon()
 * @method static self Tue()
 * @method static self Wed()
 * @method static self Thu()
 * @method static self Fri()
 * @method static self Sat()
 * @method static self Sun()
 */
final class ThreeLettersWeekdayEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Mon' => 1,
            'Tue' => 2,
            'Wed' => 3,
            'Thu' => 4,
            'Fri' => 5,
            'Sat' => 6,
            'Sun' => 7,
        ];
    }
}
