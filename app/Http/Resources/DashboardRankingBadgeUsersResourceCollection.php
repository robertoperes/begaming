<?php

namespace App\Http\Resources;

class DashboardRankingBadgeUsersResourceCollection extends ResourceCollectionAbstract
{
    public function toArray($request)
    {
        return [
            'data'  => $this->collection,
        ];
    }
}