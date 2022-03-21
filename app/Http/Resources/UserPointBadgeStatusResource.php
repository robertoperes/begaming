<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPointBadgeStatusResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'active'      => $this->active,
        ];
    }
}