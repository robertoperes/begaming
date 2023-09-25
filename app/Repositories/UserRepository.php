<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends RepositoryAbstract
{

    protected $model = User::class;

    public function findUserBy(array $filter): Collection
    {
        return $this->createModel()->where($filter)->get();
    }

    public function getUsersToInactive(array $ids)
    {
        return $this->createModel()
            ->where('active', true)
            ->whereNotIn('id', $ids);
    }

}