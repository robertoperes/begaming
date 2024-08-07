<?php

namespace App\Repositories;

use App\Models\UserBadge;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserBadgeRepository extends RepositoryAbstract
{

    protected $model = UserBadge::class;

    public function rankingBadgeUsers()
    {
        return DB::connection()->select('SELECT *
            FROM (
                     SELECT user.id,
                            count(*)                   as total,
                            user.admission_date as admission_date,
                            user.name,
                            user.google_avatar,
                            user.active
                     FROM user
                              INNER JOIN user_badge ON user_badge.user_id = user.id
                     WHERE user.active = true AND user.id NOT IN(70, 71, 72)
                     GROUP BY user.id
                 ) as tb
            ORDER BY tb.total DESC, tb.admission_date ASC
            LIMIT 5');
    }


    public function findAll(array $filter, string $orderKey = null, string $orderType = 'ASC'): Collection
    {
        $model = $this->createModel()
            ->select('user_badge.*')
            ->join('user', 'user.id','=', 'user_badge.user_id')
            ->join('badge','badge.id', '=', 'user_badge.badge_id');

        if ($orderKey) {
            return $model->where($filter)->orderBy($orderKey, $orderType)->get();
        }
        return $model->where($filter)->get();
    }
}