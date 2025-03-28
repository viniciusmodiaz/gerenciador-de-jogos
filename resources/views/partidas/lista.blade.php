@foreach ($jogos as $jogo)
<tr>
    <td class="py-2 px-4 border-b">{{ $jogo->timeCasa->nome }}</td>
    <td class="py-2 px-4 border-b">{{ $jogo->timeFora->nome }}</td>
    <td class="py-2 px-4 border-b">{{ $jogo->data_do_jogo }}</td>
    <td class="py-2 px-4 border-b">{{ $jogo->horario_inicio }}</td>
    <td class="py-2 px-4 border-b">{{ $jogo->resultado ?? 'Aguardando' }}</td>
    <td class="py-2 px-4 border-b">
        <button class="text-blue-600 hover:text-blue-700 editar-jogo" data-jogo-id="{{ $jogo->id }}">Editar</button>
    </td>
</tr>
@endforeach