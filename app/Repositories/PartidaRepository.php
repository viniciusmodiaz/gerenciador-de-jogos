<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Partida;

class PartidaRepository 
{
    public function __construct(
        private Partida $partida
    )
    {
        $this->partida = $partida;
    }

    public function criar(array $params)
    {
        
        if(empty($params["casa_time_id"]) || empty($params["fora_time_id"])){
            return;
        }

        $data = $this->partida->where('casa_time_id', $params["casa_time_id"])->where('fora_time_id', $params["fora_time_id"])->where('data_do_jogo', $params["data_do_jogo"])->first();


        if(!$data){
            return $this->partida->create($params);
        }
        
        return;
    }

    public function criarPartida(array $params)
    {
        
        if(empty($params["casa_time_id"]) || empty($params["fora_time_id"])){
            return;
        }

        $data = $this->partida->where('casa_time_id', $params["casa_time_id"])->where('fora_time_id', $params["fora_time_id"])->where('data_do_jogo', $params["data_do_jogo"])->where('competicao_id', $params['competicao_id'])->first();

        if(!$data){
            return $this->partida->create($params);
        }
        
        $data->update($params);
        return $data;
    }

    public function getJogosGemini()
    {
        return $this->partida->with(['timeCasa', 'timeFora'])->where('gemini_poisson', 0)->get();
    }
    
    public function whereJogos($timeCasaId, $timeForaId)
    {
        $dataInicial = '2025-01-01';
        $dataHoje = date('Y-m-d');
        return  $this->partida->with(['timeCasa', 'timeFora'])->where(function ($query) use ($timeCasaId, $timeForaId) {
                    $query->where($timeCasaId)
                        ->orWhere($timeForaId);
                })
                ->whereBetween('data_do_jogo', [$dataInicial, $dataHoje])
                ->whereNotNull('resultado')
                ->where('resultado', '!=' ,'Jogo adiado!')
                ->orderBy('data_do_jogo', 'desc')
                ->limit(8)
                ->get();
    }

    public function whereJogosDiretos($timeCasaId, $timeForaId)
    {
        return Partida::where(function ($query) use ($timeCasaId, $timeForaId) {
            $query->where('casa_time_id', $timeCasaId)
                  ->where('fora_time_id', $timeForaId);
        })->orWhere(function ($query) use ($timeCasaId, $timeForaId) {
            $query->where('casa_time_id', $timeForaId)
                  ->where('fora_time_id', $timeCasaId);
        })->get();
    }

    public function analiseUltimosJogos($params)
    {
        

        $gols_partidas_em_casa_10_jogos_em_todos_campeonatos = $this->getTotalGolsCasaUltimosJogos($params['time_id'], 10);

        $gols_partidas_em_fora_10_jogos_em_todos_campeonatos = $this->getTotalGolsCasaUltimosJogos($params['time_id'], 10);

        $gols_partidas_em_casa_5_jogos_em_todos_campeonatos = $this->getTotalGolsCasaUltimosJogos($params['time_id'], 5);

        $gols_partidas_em_fora_5_jogos_em_todos_campeonatos = $this->getTotalGolsForaUltimosJogos($params['time_id'], 5);
    }

    public function getTotalGolsCasaUltimosJogos($id, $paridas)
    {
        return $this->partida
            ->where('casa_time_id', $timeCasaId)
            ->orderBy('data_do_jogo', 'desc')
            ->take($partidas)
            ->sum('gols_casa');
    }

    public function getTotalGolsForaUltimosJogos($id, $paridas)
    {
        return $this->partida
            ->where('fora_time_id', $timeCasaId)
            ->orderBy('data_do_jogo', 'desc')
            ->take($partidas)
            ->sum('fora_casa');
    }

    public function whereDay($params)
    {
        return $this->partida
            ->where($params)
            ->orderBy('horario_inicio', 'desc')
            ->paginate(10);
    }

    public function whereNameTimes($params)
    {
        return $jogos = Partida::with(['timeCasa', 'timeFora'])
            ->whereHas('timeCasa', function ($query) use ($params) {
                $query->where('nome', 'like', "%{$params}%");
            })
            ->orWhereHas('timeFora', function ($query) use ($params) {
                $query->where('nome', 'like', "%{$params}%");
            })
            ->get();
    }
}