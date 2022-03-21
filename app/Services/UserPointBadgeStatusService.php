<?php

namespace App\Services;

use App\Models\UserPointBadge;
use App\Models\UserPointBadgeStatus;
use App\Repositories\UserPointBadgeRepository;
use App\Repositories\UserPointBadgeStatusRepository;
use Illuminate\Database\Eloquent\Model;

class UserPointBadgeStatusService
{

    /* @var UserPointBadgeStatusRepository */
    protected $userPointBadgeStatusRepository;

    public function __construct(UserPointBadgeStatusRepository $userPointBadgeStatusRepository)
    {
        $this->userPointBadgeStatusRepository = $userPointBadgeStatusRepository;
    }

    public function get(int $id): ?UserPointBadgeStatus
    {
        return $this->userPointBadgeStatusRepository->findOneBy('id', $id);
    }

    public function list($filters, $order = 'id', $orderType = 'ASC')
    {
        return $this->userPointBadgeStatusRepository->findAll($filters, $order, $orderType);
    }

    public function create(array $data)
    {
        return $this->userPointBadgeStatusRepository->create($data);
    }

    public function update(Model $model, array $data)
    {
        return $this->userPointBadgeStatusRepository->update($model, $data);
    }

}