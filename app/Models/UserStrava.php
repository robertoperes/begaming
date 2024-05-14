<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'updated_at',
        'last_fetch_at'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function activites(): HasMany
    {
        return $this->hasMany(UserStravaActivit::class, 'user_strava_id', 'id');
    }
}
