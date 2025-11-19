<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'prompt',
        'subject_id',
        'level_id',
        'discuss_id',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function discuss()
    {
        return $this->belongsTo(Discuss::class);
    }
}
