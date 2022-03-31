<?php

namespace App\Services;

use App\Models\UserStravaActivit;
use App\Repositories\UserStravaActivitRepository;
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

}