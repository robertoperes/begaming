<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BadgeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'icon'           => $this->icon,
            'active'         => $this->active,
            'name'           => $this->name,
            'description'    => $this->description,
            'value'          => $this->value,
            'type'           => [
                'id'          => $this->type->id,
                'icon'        => $this->type->icon,
                'description' => $this->type->description
            ],
            'classification' => [
                'id'          => $this->classification->id,
                'description' => $this->classification->description,
                'color'       => $this->classification->color
            ]
        ];
    }

}