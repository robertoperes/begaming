<?php

namespace App\Repositories;

use App\Models\UserBadge;
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
                            MIN(user_badge.created_at) as created_at,
                            user.name,
                            user.google_avatar,
                            user.active
                     FROM user
                              INNER JOIN user_badge ON user_badge.user_id = user.id
                     WHERE user.active = true
                     GROUP BY user.id
                 ) as tb
            ORDER BY tb.total DESC, tb.created_at ASC
            LIMIT 5');
    }

}