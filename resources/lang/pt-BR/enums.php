<?php

use App\Enuns\BadgeClassificationEnum;
use App\Enuns\BadgeTypeEnum;

return [
    'badge-type' => [
        BadgeTypeEnum::WELL_BEING   => 'Bem estar',
        BadgeTypeEnum::EVOLUTION    => 'Evolução',
        BadgeTypeEnum::ENGAGEMENT   => 'Engajamento',
        BadgeTypeEnum::COMPANY_TIME => 'Tempo de empresa',
        BadgeTypeEnum::ADMIRATION   => 'Admiração',
        BadgeTypeEnum::CULTURE      => 'Cultura',
    ],
    'badge-classification' => [
        BadgeClassificationEnum::CLASSIC => 'Classic',
        BadgeClassificationEnum::SILVER  => 'Silver',
        BadgeClassificationEnum::GOLD    => 'Gold',
        BadgeClassificationEnum::BLACK   => 'Black',
    ]
];