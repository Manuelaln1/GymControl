<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treino extends Model
{
    protected $fillable = [
        'user_id',
        'professor_id',
        'nome',
        'objetivo',
        'observacoes',
        'pdf_caminho',
        'ativo'
    ];

    public function aluno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function treinoExercicios()
    {
        return $this->hasMany(TreinoExercicio::class);
    }
}