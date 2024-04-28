<?php

namespace App\Http\Resources\Export;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBadgeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            $this->user->name,
            $this->badge->name . ' - ' . $this->badge->classification->description,
            Carbon::parse($this->created_at,
                'UTC')->timezone('America/Campo_Grande')->format
            ('d/m/Y'),
        ];
    }

}