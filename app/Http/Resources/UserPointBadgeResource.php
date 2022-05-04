<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPointBadgeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'user'        => [
                'id'   => $this->user->id,
                'name' => $this->user->name
            ],
            'value'       => $this->value,
            'description' => $this->description,
            'type'        => [
                'id'          => $this->type->id,
                'icon'        => $this->type->icon,
                'description' => $this->type->description
            ],
            'status'      => [
                'id'          => $this->status->id,
                'description' => $this->status->description
            ],
            'user_input'  => [
                'id'   => $this->inputUser->id,
                'name' => $this->inputUser->name
            ],
            'event_date'  => Carbon::parse($this->event_date,
                'UTC')->format
            ('Y-m-d'),
        ];
    }

}