<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'role',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Проверка: админ ли пользователь
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Проверка: обычный ли пользователь
    public function isUser()
    {
        return $this->role === 'user';
    }
}
