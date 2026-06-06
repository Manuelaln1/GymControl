<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Matricula;

class Plano extends Model
{
    protected $fillable = [
        'academia_id',
        'nome',
        'preco',
        'duracao_dias',
        'ativo'
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }
}
