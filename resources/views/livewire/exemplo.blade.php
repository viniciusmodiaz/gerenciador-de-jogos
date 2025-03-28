<div>
    <h1>{{ $mensagem }}</h1>

    <input type="text" wire:model="mensagem">

    <button wire:click="atualizarMensagem('Nova Mensagem')">Atualizar Mensagem</button>
</div>