<?php

namespace App\Repositories;

use App\Enuns\UserPointBadgeStatusEnum;
use App\Models\UserPointBadge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserPointBadgeRepository extends RepositoryAbstract
{
    protected $model = UserPointBadge::class;

    public function findBadgeTypeDate(int $user_id, int $badge_type_id, string $date): ?Model
    {
        $builder = $this->createModel()
            ->where('user_id', '=', $user_id)
            ->where('badge_type_id', '=', $badge_type_id)
            ->where(DB::raw('DATE(event_date)'),
                '=',
                $date);
        return
            $builder->first();
    }

    public function rankingUsersPointsBadges()
    {
        return DB::connection()->select('
                SELECT tb_rank.user_id,
                       tb_rank.user_name,
                       tb_rank.user_google_avatar,
                       tb_rank.badge_id,
                       tb_rank.badge_icon,
                       badge_name,
                       badge_type_id,
                       badge_type_description,
                       badge_classification_id,
                       badge_classification_description,
                       MIN(tb_rank.badge_value) as value,
                       (tb_rank.total + IFNULL(tb_rank.total_history,0)) as total,
                       admission_date
                FROM (SELECT tb_users.*,
                             badge.id                         as badge_id,
                             badge.name                       as badge_name,
                             badge.value                      as badge_value,
                             badge.icon                       as badge_icon,
                             user_badge.id                    as user_badge_id,
                             badge_type.description           as badge_type_description,
                             badge.badge_classification_id    as badge_classification_id,
                             badge_classification.description as badge_classification_description
                      FROM (SELECT user.id                     as user_id,
                                   user.name                   as user_name,
                                   user.google_avatar          as user_google_avatar,
                                   SUM(user_point_badge.value) as total,
                                   (SELECT 
                                        SUM(value) as total 
                                    FROM 
                                        user_point_badge_history 
                                    WHERE 
                                        (user_point_badge_history.user_id = user.id AND 
                                         user_point_badge_history.badge_type_id = user_point_badge.badge_type_id)) as total_history,
                                   user_point_badge.badge_type_id,
                                   user.admission_date         as admission_date
                            FROM user
                                     INNER JOIN user_point_badge ON (user_point_badge.user_id = user.id)
                            WHERE user.active AND user.id NOT IN(70, 71, 72)
                            GROUP BY user.id, user_point_badge.badge_type_id) as tb_users
                               INNER JOIN badge ON (badge.badge_type_id = tb_users.badge_type_id)
                               INNER JOIN badge_classification ON (badge_classification.id = badge.badge_classification_id)
                               INNER JOIN badge_type ON (badge_type.id = badge.badge_type_id)
                               LEFT JOIN user_badge ON (user_badge.user_id = tb_users.user_id AND user_badge.badge_id = badge.id)
                      ORDER BY user_id, badge.value) as tb_rank
                WHERE tb_rank.user_badge_id IS NULL
                GROUP BY tb_rank.user_id, tb_rank.badge_type_id
                ORDER BY tb_rank.badge_classification_id DESC, tb_rank.admission_date;
        ');
    }

    public function listTotalUsersPointsBadges(int $user_id)
    {
        return DB::connection()->select('
                SELECT 
                    badge_type.*, (SUM(IFNULL(user_point_badge.value,0)) + 
                    IFNULL((SELECT SUM(value) as total FROM user_point_badge_history WHERE 
                                        (user_point_badge_history.user_id =  ' . $user_id . ' AND 
                                         user_point_badge_history.badge_type_id = user_point_badge.badge_type_id)),0)
                    ) as total ,
                FROM 
                    badge_type
                    LEFT JOIN user_point_badge ON (
                        user_point_badge.badge_type_id = badge_type.id 
                            AND user_id = ' . $user_id . ' ) 
                GROUP BY badge_type.id ORDER BY badge_type.description;
        ');
    }
}