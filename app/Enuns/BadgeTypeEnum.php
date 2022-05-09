<?php

namespace App\Enuns;

use BenSampo\Enum\Enum;

class BadgeTypeEnum extends Enum
{
    const WELL_BEING   = 1;
    const EVOLUTION    = 2;
    const ENGAGEMENT   = 3;
    const COMPANY_TIME = 4;
    const ADMIRATION   = 5;
    const CULTURE      = 6;

    public static function getDescription($value): string
    {
        $localizedStringKey = 'enums.badge-type.' . $value;

        if (strpos(__($localizedStringKey), 'enums.') !== 0) {
            return __($localizedStringKey);
        }

        return parent::getDescription($value);
    }
}