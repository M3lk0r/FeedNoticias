<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // se desejar usar API Tokens

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'provider', 'provider_id', 'role'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Verifica se o usuário é administrador
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}