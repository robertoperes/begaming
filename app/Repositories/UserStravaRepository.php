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
            ->where('user_strava.active', '=', true)
            ->where('user.active', '=', true)
            ->groupBy('user.id');
    }

    public function getExpiredUsers()
    {
        return $this->createModel()->select(['user_strava.*'])
            ->join('user', 'user.id', '=', 'user_strava.user_id')
            ->where('user.active', '=', true)
            ->where('user_strava.active', '=', true)
            ->where('user_strava.expires_at', '<=',
                Carbon::now('UTC')->toDateTimeString())
            ->orderBy('user_strava.expires_at')
            ->groupBy('user_strava.user_id');
    }
}