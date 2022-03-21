<?php

namespace App\Services;

use App\Models\UserPointBadge;
use App\Repositories\UserPointBadgeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserPointBadgeService
{

    /* @var UserPointBadgeRepository */
    protected $userPointBadgeRepository;

    public function __construct(UserPointBadgeRepository $userPointBadgeRepository)
    {
        $this->userPointBadgeRepository = $userPointBadgeRepository;
    }

    public function get(int $id): ?UserPointBadge
    {
        $point = $this->userPointBadgeRepository->findBy('id', $id)->first();

        if (!($point instanceof UserPointBadge)) {
            throw new \Exception('Ponto não encontrado');
        }

        return $point;
    }

    public function list($filters, $order = 'id', $orderType = 'ASC')
    {
        $itemsPerPage = $filters['per_page'] ?? 10;
        $page         = $filters['page'] ?? 1;

        return $this->userPointBadgeRepository->list()->paginateWithLimit($itemsPerPage, $page);
    }

    public function create(array $data)
    {
        $data['event_date'] = Carbon::parse($data['event_date'])->toDateString();
        return $this->userPointBadgeRepository->create($data);
    }

    public function update(Model $model, array $data)
    {
        $data['event_date'] = Carbon::parse($data['event_date'])->toDateString();
        return $this->userPointBadgeRepository->update($model, $data);
    }
}