<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'theme',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }
}
