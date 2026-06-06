<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    protected $fillable = [
        'academia_id',
        'user_id',
        'entrada',
        'saida'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }
}
