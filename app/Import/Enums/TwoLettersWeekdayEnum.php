<?php

namespace App\Import\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self Mo()
 * @method static self Tu()
 * @method static self We()
 * @method static self Th()
 * @method static self Fr()
 * @method static self Sa()
 * @method static self Su()
 */
final class TwoLettersWeekdayEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Mo' => 1,
            'Tu' => 2,
            'We' => 3,
            'Th' => 4,
            'Fr' => 5,
            'Sa' => 6,
            'Su' => 7,
        ];
    }
}
