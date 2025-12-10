<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fortune extends Model
{
    protected $fillable = ['message'];
    public function histories()
    {
        return $this->hasMany(FortuneHistory::class);
    }
}
