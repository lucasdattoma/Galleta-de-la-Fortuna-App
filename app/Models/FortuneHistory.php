<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FortuneHistory extends Model
{
    protected $table = 'fortune_history';

    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'fortune_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fortune()
    {
        return $this->belongsTo(Fortune::class);
    }
}
