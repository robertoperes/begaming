<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ResourceCollectionAbstract;

class RankingBadgeUsersResourceCollection extends ResourceCollectionAbstract
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}