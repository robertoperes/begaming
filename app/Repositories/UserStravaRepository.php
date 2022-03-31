<?php

namespace App\Repositories;

use App\Models\UserStrava;
use Illuminate\Database\Eloquent\Builder;

class UserStravaRepository extends RepositoryAbstract
{

    protected $model = UserStrava::class;

    public function getActiveUsers(): Builder
    {
        return $this->createModel()->select(['user_strava.*'])->join('user', 'user.id', '=', 'user_strava.user_id')
            ->where('user_strava.active', '=', true)
            ->where('user.active', '=', true);
    }
}