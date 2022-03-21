<?php

namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{

    /* @var UserRepository */
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }

    public function get(int $id): User
    {
        $user = $this->userRepository->findOneBy('id', $id);

        if (!($user instanceof User)) {
            throw new \Exception('Usuário não encontrado');
        }

        return $user;
    }

    public function list(array $filter = [], $order = 'id',string $orderType = 'ASC')
    {
//        return $this->userRepository->findAll($filter, $order, $orderType);

        return $this->userRepository->list()->paginateWithLimit(5,1);
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data): User
    {
        return $this->userRepository->update($user, $data);
    }

    public function findUserBy($filter): User
    {
        $user = $this->userRepository->findUserBy($filter)->first();

        if (!($user instanceof User)) {
            throw new \Exception('Usuário não encontrado');
        }

        return $user;
    }
}