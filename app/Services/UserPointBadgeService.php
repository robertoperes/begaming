<?php

namespace App\Services;

use App\Models\UserPointBadge;
use App\Repositories\UserPointBadgeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserPointBadgeService
{

    /* @var UserPointBadgeRepository */
    protected $userPointBadgeRepository;

    public function __construct()
    {
        $this->userPointBadgeRepository = app(UserPointBadgeRepository::class);
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

        if (isset($filters['user_id'])) {
            return $this->userPointBadgeRepository->list()->where(
                'user_id', '=', $filters['user_id']
            )->orderBy($order, $orderType)->paginateWithLimit($itemsPerPage, $page);
        }

        return $this->userPointBadgeRepository->list()->orderBy($order, $orderType)->paginateWithLimit($itemsPerPage,
            $page);
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

    public function findBadgeTypeDate(int $user_id, int $badge_type_id, string $date)
    {
        $point = $this->userPointBadgeRepository->findBadgeTypeDate($user_id, $badge_type_id, $date);

        if (!($point instanceof UserPointBadge)) {
            throw new \Exception('Ponto não encontrado');
        }
        return $point;
    }

    public function findAll(array $filters): Collection
    {
        return $this->userPointBadgeRepository->findAll($filters);
    }

    public function rankingUsersPointsBadges()
    {
        return $this->userPointBadgeRepository->rankingUsersPointsBadges();
    }

    public function listTotalUsersPointsBadges(int $user_id)
    {
        return $this->userPointBadgeRepository->listTotalUsersPointsBadges($user_id);
    }
}