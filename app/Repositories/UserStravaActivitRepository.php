<?php

namespace App\Repositories;

use App\Models\UserStravaActivit;

class UserStravaActivitRepository extends RepositoryAbstract
{

    protected $model = UserStravaActivit::class;

    public function createOrUpdate($data)
    {
        return $this->createModel()->fill($data)->save();
    }

}