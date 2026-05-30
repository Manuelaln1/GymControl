<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treino extends Model
{
    protected $fillable = [
        'user_id',
        'nome',
        'objetivo',
        'observacoes',
        'pdf_caminho',
        'ativo'
    ];

    // 🔥 ESSA É A RELAÇÃO QUE ESTAVA FALTANDO
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}