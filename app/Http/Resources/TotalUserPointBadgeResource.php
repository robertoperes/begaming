<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TotalUserPointBadgeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'total'       => (int)$this->total,
            'description' => $this->description,
            'icon'        => $this->icon,
        ];
    }

}