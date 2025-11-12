<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'theme',
    ];

    public function studies()
    {
        return $this->hasMany(Study::class);
    }
}
