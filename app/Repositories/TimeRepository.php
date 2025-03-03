<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Time;

class TimeRepository 
{
    public function __construct(private Time $time)
    {
        $this->time = $time;
    }

    public function criar(array $params)
    {
        if(empty($params["nome"])){
            return;
        }

        $data = $this->time->where('nome', $params)->first();

        if(!$data){
            return $this->time->create($params);
        }
        
        return $data;
    }
}