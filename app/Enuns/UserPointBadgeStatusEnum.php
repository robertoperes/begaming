<?php

namespace App\Enuns;

use BenSampo\Enum\Enum;

class UserPointBadgeStatusEnum extends Enum
{
    const WAITING          = 1;
    const WAITING_APPROVAL = 2;
    const APPROVED         = 3;
    const COMPENSATED      = 4;
    const DISABLED         = 5;
}