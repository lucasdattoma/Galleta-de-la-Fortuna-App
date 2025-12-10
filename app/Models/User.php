<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ← IMPORTAR ESTO

class User extends Authenticatable
{
    use Notifiable, HasApiTokens; // ← AGREGAR HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function fortuneHistories()
    {
        return $this->hasMany(FortuneHistory::class);
    }

    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }
}
