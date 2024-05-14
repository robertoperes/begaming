<?php

namespace App\Repositories;

use App\Models\UserStrava;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserStravaRepository extends RepositoryAbstract
{

    protected $model = UserStrava::class;

    public function getActiveUsers(): Builder
    {
        return $this->createModel()->select([
            'user.admission_date',
            'user_strava.*'
        ])->join('user', 'user.id', '=', 'user_strava.user_id')
            ->where('user_strava.last_fetch_at','<=', Carbon::now()->subHour()->toDateTimeString())
            ->where('user_strava.active', '=', true)
            ->where('user.active', '=', true);
    }

    public function getExpiredUsers()
    {
        return $this->createModel()->select(['*'])
            ->join('user', 'user.id', '=', 'user_strava.user_id')
            ->where('user.active', '=', true)
            ->orderBy('user_strava.created_at', 'DESC')
            ->groupBy('user_strava.user_id');
    }
}