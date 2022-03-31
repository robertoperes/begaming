<?php

namespace App\Repositories;

use App\Models\UserBadge;
use Illuminate\Support\Facades\DB;

class UserBadgeRepository extends RepositoryAbstract
{

    protected $model = UserBadge::class;

    public function rankingBadgeUsers()
    {
        return $this->createModel()->select(
            DB::raw('count( badge_id ) as total'),
            'user.name',
            'user.google_avatar'
        )->join(
            'user',
            'user.id',
            '=',
            'user_badge.user_id'
        )->where('user.active', '=', true)->groupBy('user.id')->orderBy('total','DESC')->limit(5)->get();
    }

}