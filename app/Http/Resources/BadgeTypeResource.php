<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BadgeTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'icon'        => $this->icon,
            'active'      => $this->active,
        ];
    }

}