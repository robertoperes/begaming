<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends RepositoryAbstract
{

    protected $model = User::class;

    public function findUserBy(array $filter): Collection
    {
        return $this->createModel()->where($filter)->get();
    }

}