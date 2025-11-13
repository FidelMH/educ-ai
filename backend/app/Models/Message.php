<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
     protected $fillable = [
        'type_message',
    ];

    public function discuss()
    {
        return $this->belongsTo(Discuss::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
