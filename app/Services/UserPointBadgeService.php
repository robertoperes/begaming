<?php

namespace App\Services;

use App\Enuns\BadgeTypeEnum;
use App\Enuns\UserPointBadgeStatusEnum;
use App\Models\UserPointBadge;
use App\Models\UserStrava;
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

        unset($filters['per_page']);
        unset($filters['page']);
        return $this->userPointBadgeRepository->list($filters)->orderBy($order, $orderType)->paginateWithLimit($itemsPerPage,
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

    public function export()
    {
        return $this->userPointBadgeRepository->export();
    }

    public function rankingUsersPointsBadges()
    {
        return $this->userPointBadgeRepository->rankingUsersPointsBadges();
    }

    public function listTotalUsersPointsBadges(int $user_id)
    {
        return $this->userPointBadgeRepository->listTotalUsersPointsBadges($user_id);
    }

    public function listUserPointsBadgesReset(int $year)
    {
        return $this->userPointBadgeRepository->listUserPointsBadgesReset($year);
    }

    public function createWellBeingPoint(UserStrava $userStrava, object $activity)
    {
        $activityDate = Carbon::parse($activity->start_date_local,
            $activity->timezone);

        $event = $activityDate->format('Ym') == '202401' ? ' Campanha Janeiro Branco' : '';
        $value = $activityDate->format('Ym') == '202401' ? 2 : 1;

        try {
            $point = $this->findBadgeTypeDate($userStrava->user_id, BadgeTypeEnum::WELL_BEING,
                $activityDate->format('Y-m-d'));
        } catch (\Exception $exception) {
            $this->create([
                'user_id'                    => $userStrava->user_id,
                'badge_type_id'              => BadgeTypeEnum::WELL_BEING,
                'user_point_badge_status_id' => UserPointBadgeStatusEnum::APPROVED,
                'input_user_id'              => $userStrava->user_id,
                'value'                      => $value,
                'description'                => 'Atividade Strava'.$event,
                'event_date'                 => $activityDate->format('Y-m-d 00:00:00')
            ]);
        }
    }
}