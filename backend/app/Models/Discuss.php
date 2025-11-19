<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discuss extends Model
{
    // 1. Autoriser l'assignation de masse pour l'agent_id
    protected $fillable = ['agent_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // 2. Correction: Comme la FK est sur cette table, c'est belongsTo
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
