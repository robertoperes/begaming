<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserStrava extends Model
{
    protected $primaryKey = 'id';
    protected $table      = 'user_strava';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'active',
        'user_id',
        'athlete_id',
        'access_token',
        'refresh_token',
        'expires_at',
        'created_at',
        'updated_at'
    ];

    public function activites(): HasMany
    {
        return $this->hasMany(UserStravaActivit::class, 'user_strava_id', 'id');
    }
}
