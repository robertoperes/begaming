<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserStrava;
use App\Models\UserStravaActivit;
use App\Repositories\UserStravaActivitRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserStravaActivitService
{

    /* @var UserStravaActivitRepository */
    protected $userStravaActivitRepository;

    public function __construct()
    {
        $this->userStravaActivitRepository = app(UserStravaActivitRepository::class);
    }

    public function get(int $id): Model
    {
        $activit = $this->userStravaActivitRepository->findOneBy('id', $id);

        if (!($activit instanceof UserStravaActivit)) {
            throw new \Exception('Atividade não encontrado');
        }

        return $activit;
    }

    public function create(array $data)
    {
        return $this->userStravaActivitRepository->create($data);
    }

    public function update(Model $model, array $data)
    {
        return $this->userStravaActivitRepository->update($model, $data);
    }


    public function createActivity(UserStrava $userStrava, object $activity)
    {
        $activityDate = Carbon::parse($activity->start_date_local,
            $activity->timezone);

        $data = [
            'id'               => $activity->id,
            'user_strava_id'   => $userStrava->user_id,
            'active'           => true,
            'name'             => $activity->name,
            'type'             => $activity->type,
            'start_date_local' => $activityDate->format('Y-m-d H:i:s'),
            'elapsed_time'     => $activity->elapsed_time,
        ];

        try {
            $activitModel = $this->get($activity->id);
            $this->update($activitModel, $data);
        } catch (\Exception $exception) {
            $this->create($data);
        }
    }
}