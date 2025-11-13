<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discuss extends Model
{
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function agent()
    {
        return $this-> hasOne(Agent::class);
    }
}
