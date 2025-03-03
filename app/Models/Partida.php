<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $fillable = [
        'casa_time_id',
        'fora_time_id',
        'resultado',
        'data_do_jogo',
        'horario_inicio'
    ];
}
