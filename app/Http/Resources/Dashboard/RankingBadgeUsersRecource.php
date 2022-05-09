<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class RankingBadgeUsersRecource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name'          => $this->name,
            'google_avatar' => $this->google_avatar,
            'total'         => $this->total,
        ];
    }
}