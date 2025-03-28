<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Time;

class Partida extends Model
{
    protected $fillable = [
        'casa_time_id',
        'fora_time_id',
        'resultado',
        'data_do_jogo',
        'horario_inicio',
        'competicao_id',
        'gols_casa',
        'gols_fora',
        'gol_primeiro_tempo_casa',
        'gol_segundo_tempo_casa',
        'gol_primeiro_tempo_fora',
        'gol_segundo_tempo_fora',
        'probabilidade',
        'gemini_poisson'
    ];

    public function timeCasa()
    {
        return $this->hasOne(Time::class, 'id', 'casa_time_id');
    }

    
    public function timeFora()
    {
        return $this->hasOne(Time::class, 'id', 'fora_time_id');
    }
}
