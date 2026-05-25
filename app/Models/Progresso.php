<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progresso extends Model
{
    protected $table = 'progresso';

    protected $fillable = [
        'user_id',
        'professor_id',
        'peso_kg',
        'gordura_corporal_pct',
        'massa_muscular_kg',
        'observacoes',
        'avaliado_em'
    ];

    public function aluno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}