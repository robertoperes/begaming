<?php

namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;

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

    public function list(array $filters = [], $order = 'id', string $orderType = 'ASC')
    {
        $itemsPerPage = $filters['per_page'] ?? 10;
        $page         = $filters['page'] ?? 1;

        unset($filters['per_page']);
        unset($filters['page']);

        return $this->userRepository->list(array_filter($filters), $order, $orderType)->paginateWithLimit($itemsPerPage, $page);
    }

    public function create(array $data): User
    {
        $data['admission_date'] = isset($data['admission_date']) ? Carbon::parse($data['admission_date'])
            ->toDateString() : null;
        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data): User
    {
        $data['admission_date'] = isset($data['admission_date']) ? Carbon::parse($data['admission_date'])
            ->toDateString() : null;
        return $this->userRepository->update($user, $data);
    }

    public function findAll($filter)
    {
        return $this->userRepository->findAll($filter);
    }

    public function findUserBy($filter): User
    {
        $user = $this->userRepository->findUserBy($filter)->first();

        if (!($user instanceof User)) {
            throw new \Exception('Usuário não encontrado');
        }

        return $user;
    }

    public function inactiveOldUsers(array $ids)
    {
        $this->userRepository->getUsersToInactive($ids)->update(['active' => false]);
    }
}