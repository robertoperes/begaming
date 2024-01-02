<?php

namespace App\Repositories;

use App\Enuns\BadgeTypeEnum;
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
                SELECT user.id as user_id,
                   user.name as user_name,
                   DATE_FORMAT(user.admission_date, "%Y%m%d") as admission_date,
                   user.google_avatar as user_google_avatar,
                   badge.id as badge_id,
                   badge.name as badge_name,
                   badge.icon as badge_icon,
                   badge.value as value,
                   badge_type.id as badge_type_id,
                   badge_type.description as badge_type_description,
                   badge_classification.id as badge_classification_id,
                   badge_classification.description as badge_classification_description,
                   IF(user_badges.badge_id IS NULL, (points.total + IFNULL(history_points.total,0)), null) as total,
                   IF(user_badges.badge_id IS NOT NULL, true, false) as has_user_badge
                FROM
                    user
                INNER JOIN badge ON (badge.active = 1)
                INNER JOIN badge_type ON (badge.badge_type_id = badge_type.id)
                INNER JOIN badge_classification ON (badge.badge_classification_id = badge_classification.id)
                LEFT JOIN (SELECT
                               user_id,
                               badge_type_id,
                               SUM(value) as total
                           FROM
                               user_point_badge
                           WHERE 
                                user_point_badge_status_id != '.UserPointBadgeStatusEnum::DISABLED.'
                           GROUP BY user_id, badge_type_id) AS points ON
                        (points.user_id = user.id AND points.badge_type_id = badge_type.id)
                LEFT JOIN (SELECT
                               user_id,
                               badge_type_id,
                               SUM(value) as total
                           FROM
                               user_point_badge_history
                           GROUP BY user_id, badge_type_id) AS history_points ON
                               (history_points.user_id = user.id AND history_points.badge_type_id = badge_type.id)
                LEFT JOIN (
                    SELECT
                        user_id,
                        badge.id as badge_id,
                        badge_type_id,
                        badge_classification_id
                    FROM
                        user_badge
                    INNER JOIN badge ON (badge.id = user_badge.badge_id)
                    ) as user_badges ON (user_badges.user_id = user.id
                                             AND user_badges.badge_type_id = badge.badge_type_id
                                             AND user_badges.badge_classification_id = badge_classification.id
                        )
            WHERE
                user.active = 1 AND user.id NOT IN(70, 71, 72) AND badge.active = 1
            GROUP BY user.id, badge.id
            ORDER BY badge.badge_type_id, badge.badge_classification_id;
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
                    ) as total
                FROM 
                    badge_type
                    LEFT JOIN user_point_badge ON (
                        user_point_badge.badge_type_id = badge_type.id 
                            AND user_id = ' . $user_id . ' AND
                            user_point_badge_status_id != '.UserPointBadgeStatusEnum::DISABLED.' 
                        ) 
                GROUP BY badge_type.id ORDER BY badge_type.description;
        ');
    }

    public function listUserPointsBadgesReset(int $year)
    {
        return DB::connection()->select('
            SELECT user_point_badge.user_id,
                 user_point_badge.badge_type_id,
                 SUM(user_point_badge.value) as total,
                 (SELECT SUM(value) as total
                  FROM user_point_badge_history
                  WHERE user_id = user_point_badge.user_id
                    AND badge_type_id = user_point_badge.badge_type_id
                  GROUP BY user_id)          as total_history
              FROM 
                  user_point_badge
              WHERE 
                  user_point_badge.user_point_badge_status_id != '.UserPointBadgeStatusEnum::DISABLED.' 
                    AND user_point_badge.badge_type_id NOT IN ('.BadgeTypeEnum::COMPANY_TIME.', '.BadgeTypeEnum::CULTURE.')
                    AND user_point_badge.user_id = 1
                    AND YEAR(user_point_badge.event_date) < '.$year.'
              GROUP BY user_point_badge.user_id, user_point_badge.badge_type_id)
        ');
    }
}