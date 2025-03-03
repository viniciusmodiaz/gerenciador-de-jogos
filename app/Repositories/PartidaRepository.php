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
}