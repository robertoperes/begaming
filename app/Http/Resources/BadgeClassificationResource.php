<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BadgeClassificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'color'       => $this->color,
            'active'      => $this->active
        ];
    }

}