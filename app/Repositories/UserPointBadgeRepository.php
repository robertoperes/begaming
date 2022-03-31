<?php

namespace App\Repositories;

use App\Models\UserPointBadge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserPointBadgeRepository extends RepositoryAbstract
{
    protected $model = UserPointBadge::class;

    public function findBadgeTypeDate(int $badge_type_id, string $date): ?Model
    {
        $builder = $this->createModel()
            ->where('badge_type_id', '=', $badge_type_id)
            ->where(DB::raw('DATE(event_date)'),
                '=',
                $date);
        return
            $builder->first();
    }
}