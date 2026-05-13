<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreinoExercicio extends Model
{
    protected $fillable = [
        'treino_id',
        'exercicio_id',
        'series',
        'repeticoes',
        'carga_kg',
        'descanso_segundos',
        'ordem',
        'observacoes'
    ];

    public function treino()
    {
        return $this->belongsTo(Treino::class);
    }

    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }
}