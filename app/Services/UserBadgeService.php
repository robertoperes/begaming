<?php

namespace App\Services;

use App\Repositories\UserBadgeRepository;

class UserBadgeService
{

    /* @var UserBadgeRepository */
    protected $userBadgeRepository;

    public function __construct()
    {
        $this->userBadgeRepository = app(UserBadgeRepository::class);
    }

    public function rankingBadgeUsers()
    {
        return $this->userBadgeRepository->rankingBadgeUsers();
    }

}