<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $strava = [];
        if (isset($this->strava)) {
            $strava = [
                'id'         => $this->strava->id,
                'athlete_id' => $this->strava->athlete_id,
                'expires_at' => $this->strava->expires_at
            ];
        }

        return [
            'id'             => $this->id,
            'admin'          => $this->admin,
            'active'         => $this->active,
            'name'           => $this->name,
            'email'          => $this->email,
            'google_avatar'  => $this->google_avatar,
            'admission_date' => Carbon::parse($this->admission_date,
                'UTC')->format
            ('Y-m-d'),
            'strava'         => $strava,
            'badges'         => new BadgeResourceCollection($this->badges)
        ];
    }
}