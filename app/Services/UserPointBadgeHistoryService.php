<?php

namespace App\Services;

use App\Repositories\UserPointBadgeHistoryRepository;

class UserPointBadgeHistoryService
{

    /* @var UserPointBadgeHistoryRepository */
    protected $userPointBadgeRepository;

    public function __construct()
    {
        $this->userPointBadgeRepository = app(UserPointBadgeHistoryRepository::class);
    }

    public function create(array $data)
    {
        return $this->userPointBadgeRepository->create($data);
    }

}