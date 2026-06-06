<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // 👈 FALTAVA ISSO

class Progresso extends Model
{
    protected $table = 'progresso';

    protected $fillable = [
        'academia_id',
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

    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }
}
