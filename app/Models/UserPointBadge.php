<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPointBadge extends Model
{
    protected $primaryKey = 'id';
    protected $table      = 'user_point_badge';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'user_id',
        'badge_type_id',
        'user_point_badge_status_id',
        'input_user_id',
        'event_date',
        'value',
        'created_at',
        'updated_at'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function inputUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'input_user_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(BadgeType::class, 'id', 'badge_type_id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(UserPointBadgeStatus::class, 'id', 'user_point_badge_status_id');
    }
}