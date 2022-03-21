<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BadgeType extends Model
{
    protected $primaryKey = 'id';
    protected $table      = 'badge_type';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'description',
        'icon',
        'active',
        'created_at',
        'updated_at'
    ];

    public function badges(): HasMany
    {
        return $this->hasMany(Badge::class,'badge_type_id','id');
    }

}
