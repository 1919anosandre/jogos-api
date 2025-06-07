<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     public function isAdmin(): bool
    {
        // Supondo que você tenha uma coluna 'role' ou 'is_admin' no banco
        // Exemplo 1: se usar uma coluna 'role' que armazena 'admin' para administradores
        return $this->role === 'admin';

        // Exemplo 2: se usar uma coluna booleana 'is_admin'
        // return $this->is_admin;
    }
}
