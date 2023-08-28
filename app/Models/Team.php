<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{

    protected $primaryKey = 'id';
    protected $table      = 'team';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'active',
        'created_at',
        'updated_at'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class,'team_id','id');
    }
}