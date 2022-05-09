<?php

namespace App\Enuns;

use BenSampo\Enum\Enum;

class BadgeClassificationEnum extends Enum
{
    const CLASSIC = 1;
    const SILVER  = 2;
    const GOLD    = 3;
    const BLACK   = 4;

    public static function getDescription($value): string
    {
        $localizedStringKey = 'enums.badge-classification.' . $value;

        if (strpos(__($localizedStringKey), 'enums.') !== 0) {
            return __($localizedStringKey);
        }

        return parent::getDescription($value);
    }
}