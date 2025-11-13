<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
