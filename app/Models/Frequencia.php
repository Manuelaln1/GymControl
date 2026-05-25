<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    protected $fillable = [
        'user_id',
        'entrada',
        'saida'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}