<?php

namespace App\Livewire;

use Livewire\Component;

class Exemplo extends Component
{
    public $mensagem = 'Olá, Livewire!';

    public function atualizarMensagem($novaMensagem)
    {
        $this->mensagem = $novaMensagem;
    }

    public function render()
    {
        return view('livewire.exemplo');
    }
}
