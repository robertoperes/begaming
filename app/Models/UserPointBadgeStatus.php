<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPointBadgeStatus extends Model
{
    protected $primaryKey = 'id';
    protected $table      = 'user_point_badge_status';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'description',
        'active',
        'created_at',
        'updated_at'
    ];

}
