<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'prompt',
    ];

    public function level()
    {
        return $this->hasOne(Level::class);
    }

    public function subject()
    {
        return $this->hasOne(Subject::class);
    }

    public function discuss()
    {
        return $this->belongsTo(Discuss::class);
    }
}
