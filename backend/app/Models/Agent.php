<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'prompt',
        'subject_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
