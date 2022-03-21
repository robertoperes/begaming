<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Badge extends Model
{

    protected $primaryKey = 'id';
    protected $table      = 'badge';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'description',
        'active',
        'icon',
        'badge_type_id',
        'badge_classification_id',
        'value',
        'created_at',
        'updated_at'
    ];

    public function type(): HasOne
    {
        return $this->hasOne(BadgeType::class, 'id', 'badge_type_id');
    }

    public function classification(): HasOne
    {
        return $this->hasOne(BadgeClassification::class, 'id', 'badge_classification_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_badge','user_id','id');
    }
}