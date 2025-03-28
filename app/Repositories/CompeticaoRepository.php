<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Competicao;

class CompeticaoRepository 
{
    public function __construct(private Competicao $competicao)
    {
        $this->model = $competicao;
    }

    public function criar(array $params)
    {
        if(empty($params["nome"])){
            return;
        }

        $data = $this->model->where('nome', $params)->first();

        if(!$data){
            return $this->model->create($params);
        }
        
        return $data;
    }
}