<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = [
        'nome',
        'preco',
        'duracao_dias',
        'ativo'
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}