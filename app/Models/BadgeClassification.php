<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BadgeClassification extends Model
{
    protected $primaryKey = 'id';
    protected $table      = 'badge_classification';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'description',
        'color',
        'active',
        'created_at',
        'updated_at'
    ];

    public function badges(): HasMany
    {
        return $this->hasMany(Badge::class,'badge_classification_id','id');
    }
}
