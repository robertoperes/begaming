<?php

namespace App\Services;

use App\Models\UserBadge;
use App\Repositories\UserBadgeRepository;
use Illuminate\Support\Collection;

class UserBadgeService
{

    /* @var UserBadgeRepository */
    protected $userBadgeRepository;

    public function __construct()
    {
        $this->userBadgeRepository = app(UserBadgeRepository::class);
    }

    public function findAll(array $filters = [], $orderKey = 'user_badge.created_at', $order = 'ASC'): Collection
    {
        return $this->userBadgeRepository->findAll($filters, $orderKey, $order);
    }

    public function create(array $data): UserBadge
    {
        return $this->userBadgeRepository->create($data);
    }

    public function rankingBadgeUsers()
    {
        return $this->userBadgeRepository->rankingBadgeUsers();
    }

}