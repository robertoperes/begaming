<?php

namespace App\Services;

use App\Repositories\BadgeTypeRepository;

class BadgeTypeService
{
    /* @var BadgeTypeRepository */
    protected $badgeTypeRepository;

    public function __construct()
    {
        $this->badgeTypeRepository = app(BadgeTypeRepository::class);
    }

    public function list($filter, $order = 'id')
    {
        return $this->badgeTypeRepository->findAll($filter, $order);
    }

}