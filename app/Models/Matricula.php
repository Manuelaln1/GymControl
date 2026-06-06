<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = [
        'academia_id',
        'user_id',
        'plano_id',
        'data_inicio',
        'data_fim',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }
}
