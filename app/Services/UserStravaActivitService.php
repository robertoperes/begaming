<?php

namespace App\Services;

use App\Models\User;
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


    public function createActivit(User $user, $activit)
    {
        $activitDate = Carbon::parse($activit->start_date_local,
            $activit->timezone);

        $data = [
            'id'               => $activit->id,
            'user_strava_id'   => $user->id,
            'active'           => true,
            'name'             => $activit->name,
            'type'             => $activit->type,
            'start_date_local' => $activitDate->format('Y-m-d H:i:s'),
            'elapsed_time'     => $activit->elapsed_time,
        ];

        try {
            $activitModel = $this->get($activit->id);
            $this->update($activitModel, $data);
        } catch (\Exception $exception) {
            $this->create($data);
        }
    }
}