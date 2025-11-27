<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'type_message',
        'message',
        'user_id',
        'discuss_id',
        'agent_id',
    ];

    public function discuss()
    {
        return $this->belongsTo(Discuss::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
