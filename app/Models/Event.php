<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{

    protected $primaryKey = 'id';
    protected $table      = 'event';
    public    $timestamps = true;

    protected $fillable = [
        'id',
        'title',
        'code',
        'description',
        'date_start',
        'date_end',
        'created_at',
        'updated_at'
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_event','user_id','id');
    }
}