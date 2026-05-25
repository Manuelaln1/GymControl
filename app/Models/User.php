<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function treinos()
    {
        return $this->hasMany(Treino::class);
    }

    public function treinosComoProfessor()
    {
        return $this->hasMany(Treino::class, 'professor_id');
    }

    public function progresso()
    {
        return $this->hasMany(Progresso::class);
    }

    public function progressoComoProfessor()
    {
        return $this->hasMany(Progresso::class, 'professor_id');
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class);
    }
}