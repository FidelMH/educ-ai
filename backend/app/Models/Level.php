<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'description',
        'level',
    ];

    public function has()
    {
        return $this->hasOne(Has::class);
    }

    // public function subjects()
    // {
    //     return $this->hasOne(Subject::class);
    // }

    public function users()
    {
        return $this->hasMany(User::class, 'level_id');
    }
}
