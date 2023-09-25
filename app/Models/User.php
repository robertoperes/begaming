<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    protected $table      = 'user';
    public    $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'team_id',
        'active',
        'password',
        'admission_date',
        'api_token',
        'admin',
        'google_id',
        'google_avatar',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'google_id',
        'email_verified_at'
    ];

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badge', 'user_id', 'badge_id');
    }

    public function points(): HasMany
    {
        return $this->hasMany(UserPointBadge::class, 'user_id', 'id');
    }

    public function strava(): HasOne
    {
        return $this->hasOne(UserStrava::class, 'user_id', 'id')->where('user_strava.active', '=', true);
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'user_event', 'user_id', 'id');
    }
}
