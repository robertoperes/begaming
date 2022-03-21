<?php

namespace App\Models;

use CodeToad\Strava\Strava;
use Illuminate\Database\Eloquent\Collection;
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
        'active',
        'password',
        'admission_date',
        'api_token',
        'admin',
        'created_at',
        'updated_at',
        'google_avatar'
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
        return $this->belongsToMany(Badge::class, 'user_badge', 'user_id', 'id');
    }

    public function points()
    {
        return $this->hasMany(UserPointBadge::class, 'user_id', 'id');
    }

    public function strava()
    {
        return $this->hasOne(UserStrava::class, 'user_id', 'id');
    }

}
