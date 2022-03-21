<?php

namespace App\Services;

use App\Repositories\BadgeClassificationRepository;

class BadgeClassificationService
{
    /* @var BadgeClassificationRepository */
    protected $badgeClassificationRepository;

    public function __construct()
    {
        $this->badgeClassificationRepository = app(BadgeClassificationRepository::class);
    }

    public function list($filter, $order = 'id')
    {
        return $this->badgeClassificationRepository->findAll($filter, $order);
    }

}