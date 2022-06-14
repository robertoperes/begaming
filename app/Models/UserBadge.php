<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserBadge extends Model
{
    protected $primaryKey = 'id';
    protected $table      = 'user_badge';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'badge_id',
        'user_id',
        'description',
        'created_at',
        'updated_at'
    ];

    public function badge(): HasOne
    {
        return $this->hasOne(Badge::class,'id','badge_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
