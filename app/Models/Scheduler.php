<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    protected $fillable = ['name', 'event'];

    // One scheduler can have many sales
    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
}
