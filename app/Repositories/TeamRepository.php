<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository extends RepositoryAbstract
{
    protected $model = Team::class;

    public function findUserBy(array $filter): Collection
    {
        return $this->createModel()->where($filter)->get();
    }
}