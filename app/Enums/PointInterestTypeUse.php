<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PointInterestTypeUse extends Enum
{
    const Health = 1;
    const Financial = 2;
    const Religious = 3;
    const Utilities = 4;
    const Place = 5;
    const Recreation  =  6;
    const Touristic  =  7;
    const Education  =  8;
}
