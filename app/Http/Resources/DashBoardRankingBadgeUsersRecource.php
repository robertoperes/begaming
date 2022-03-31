<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashBoardRankingBadgeUsersRecource extends JsonResource
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