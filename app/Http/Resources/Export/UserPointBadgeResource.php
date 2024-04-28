<?php

namespace App\Http\Resources\Export;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPointBadgeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            $this->user->name,
            $this->type->description,
            $this->user->team->name ?? "",
            $this->value,
            $this->description,
            Carbon::parse($this->event_date)->format('d/m/Y'),
        ];
    }

}