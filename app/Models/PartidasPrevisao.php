<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Time;
use App\Models\Partida;

class PartidasPrevisao extends Model
{
    protected $table = "partidas_previsao";

    protected $fillable = [
        'resultado',
        'gols_casa',
        'gols_fora',
        'gol_primeiro_tempo_casa',
        'gol_segundo_tempo_casa',
        'gol_primeiro_tempo_fora',
        'gol_segundo_tempo_fora',
        'probabilidade_gemini',
        'partida_id',
        'probabilidade_time_casa_forebet',
        'probabilidade_time_fora_forebet',
        'probabilidade_empate_forebet',
        'probabilidade_mais_gols_forebet',
        'probabilidade_menos_gols_forebet',
        'probabilidade_time_casa_footystats',
        'probabilidade_time_fora_footystats',
        'probabilidade_empate_footystats',
        'mais_0_5_footystats',
        'mais_1_5_footystats',
        'mais_2_5_footystats',
        'mais_3_5_footystats',
        'mais_4_5_footystats'
    ];

    public function partida()
    {
        return $this->hasOne(Partida::class, 'id', 'partida_id');
    }
}
