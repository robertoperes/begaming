<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserStrava;
use App\Repositories\UserStravaRepository;

class UserStravaService
{

    /* @var UserStravaRepository */
    protected $userStravaRepository;

    public function __construct()
    {
        $this->userStravaRepository = app(UserStravaRepository::class);
    }

    public function findByUser(int $userId): UserStrava
    {
        $userStrava = $this->userStravaRepository->findBy('user_id',$userId)->first();

        if (!($userStrava instanceof UserStrava)) {
            throw new \Exception('Usuário não cadastrado');
        }

        return $userStrava;
    }

    public function create(array $data): UserStrava
    {
        return $this->userStravaRepository->create($data);
    }

    public function update(UserStrava $userStrava, array $data): UserStrava
    {
        return $this->userStravaRepository->update($userStrava, $data);
    }

    public function getActiveUsers()
    {
        return $this->userStravaRepository->getActiveUsers()->get();
    }
}