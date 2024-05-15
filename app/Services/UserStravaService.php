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
        $userStrava = $this->userStravaRepository->findAll([
            'user_id' => $userId,
            'active'  => true
        ])->first();

        if (!($userStrava instanceof UserStrava)) {
            throw new \Exception('Usuário não cadastrado');
        }

        return $userStrava;
    }

    public function findActiveTokenBy(string $key, string $value): UserStrava
    {
        $userStrava = $this->userStravaRepository
            ->findBy($key, $value)
            ->where('active', true)
            ->first();

        if (!($userStrava instanceof UserStrava)) {
            throw new \Exception('Usuário não cadastrado');
        }

        return $userStrava;
    }
    public function findBy(string $key, string $value): UserStrava
    {
        $userStrava = $this->userStravaRepository->findBy($key, $value)->first();

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

    public function delete(UserStrava $userStrava)
    {
        return $this->userStravaRepository->delete($userStrava);
    }

    public function getActiveUsers()
    {
        return $this->userStravaRepository->getActiveUsers()->get();
    }

    public function getExpiredUsers()
    {
        return $this->userStravaRepository->getExpiredUsers()->get();
    }
}