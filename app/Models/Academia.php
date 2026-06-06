<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'telefone',
        'endereco',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function planos()
    {
        return $this->hasMany(Plano::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function treinos()
    {
        return $this->hasMany(Treino::class);
    }

    public function progresso()
    {
        return $this->hasMany(Progresso::class);
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class);
    }
}
