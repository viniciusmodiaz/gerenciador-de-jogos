<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

class Repository 
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $userDetails): Model
    {
        return $this->model->create($userDetails);
    }

    public function one(array $params): ?Model
    {
        return $this->model->where($params)->first();
    }

    public function updateExist(array $params)
    {
        $this->model->fill($params)->save();
        return $model;
    }

    public function criarOuAtualizar(array $params)
    {
        return $this->model->firstOrCreate($params);
    }

    public function criar(array $params)
    {

        if(empty($params["nome"])){
            dd('vazio');
        }
        dd($this->model);

        $data = $this->model->where('nome', 'teste')->first();

        dd($this->model);

        if($data->isEmpty()){
            return $this->model->create($params);

        }
        
        return;
    }

}