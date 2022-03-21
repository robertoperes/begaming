<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserStravaActivit extends Model
{
    protected $primaryKey = 'id';
    protected $table      = 'user_strava_activit';
    public    $timestamps = true;

    protected $fillable = [
        'user_strava_id',
        'active',
        'name',
        'type',
        'start_date_local',
        'elapsed_time',
        'description',
        'created_at',
        'updated_at'
    ];

    public function strava(): HasOne
    {
        return $this->hasOne(UserStrava::class, 'id', 'user_strava_id');
    }
}
