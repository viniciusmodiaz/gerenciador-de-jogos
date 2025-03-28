<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Jogos</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-4">

    <div class="container mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Jogos</h1>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Adicionar Jogo</button>
        </div>

        <p class="text-sm text-gray-600 mb-4">Uma lista de todos os jogos na sua conta, incluindo nome dos times, data e resultado.</p>

        <div class="mb-4">
            <input type="text" id="busca" class="border rounded px-3 py-2 w-full" placeholder="Buscar jogos...">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Time Casa</th>
                        <th class="py-2 px-4 border-b text-left">Time Fora</th>
                        <th class="py-2 px-4 border-b text-left">Data</th>
                        <th class="py-2 px-4 border-b text-left">Horario</th>
                        <th class="py-2 px-4 border-b text-left">Resultado</th>
                        <th class="py-2 px-4 border-b text-left">Ações</th>
                    </tr>
                </thead>
                <tbody id="listaJogos">
                    @include('partidas.lista')
                </tbody>
            </table>
            <div class="mt-4">
                {{ $jogos->links() }}
            </div>
        </div>
    </div>

    <div id="modalEditarJogo" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form id="formEditarJogo" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">Forebet</h3>
                        <div class="mb-2">
                            <label for="probabilidade_time_casa_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. Time Casa</label>
                            <input type="number" name="probabilidade_time_casa_forebet" id="probabilidade_time_casa_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label for="probabilidade_empate_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. Empate</label>
                            <input type="number" name="probabilidade_empate_forebet" id="probabilidade_empate_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label for="probabilidade_time_fora_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. Time Fora</label>
                            <input type="number" name="probabilidade_time_fora_forebet" id="probabilidade_time_fora_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label for="probabilidade_mais_gols_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. 2,5 Mais Gols</label>
                            <input type="number" name="probabilidade_mais_gols_forebet" id="probabilidade_mais_gols_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label for="probabilidade_menos_gols_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. 2,5 menos Gols</label>
                            <input type="number" name="probabilidade_menos_gols_forebet" id="probabilidade_menos_gols_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Salvar</button>
                        <button type="button" onclick="fecharModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modalNewProbabilidade" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form id="formAddJogo" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4" method="POST" onsubmit="enviarFormulario(event)">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">Forebet</h3>
                        <div class="mb-2">
                            <label for="probabilidade_resultado_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. Resultado Casa</label>
                            <input type="text" name="probabilidade_resultado_forebet" id="probabilidade_resultado_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label for="probabilidade_mais_gols_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. Mais 2.5 Gols Casa</label>
                            <input type="text" name="probabilidade_mais_gols_forebet" id="probabilidade_mais_gols_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label for="probabilidade_mais_gols_forebet" class="block text-gray-700 text-sm font-bold mb-2">Prob. Mais 2.5 Gols Casa</label>
                            <input type="text" name="probabilidade_mais_gols_forebet" id="probabilidade_mais_gols_forebet" class="border rounded px-3 py-2 w-full">
                        </div>
                        <h3 class="text-lg font-semibold mb-2">footystats</h3>
                        <div class="mb-2">
                            <label for="probabilidade_footystats" class="block text-gray-700 text-sm font-bold mb-2">Prob. Mais 2.5 Gols Casa</label>
                            <textarea 
                                id="probabilidade_footystats" 
                                rows="4" 
                                class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-blue-500"
                                placeholder="Digite aqui..."
                            ></textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Salvar</button>
                        <button type="button" onclick="fecharModalNewProbabilidade()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<script>
    function abrirModal(jogoId) {
        fetch(`/jogos/previsao/${jogoId}`)
            .then(response => response.json())
            .then(jogo => {
                if (jogo.probabilidade_time_casa_forebet === undefined || jogo.probabilidade_time_fora_forebet === undefined) {
                    document.getElementById('modalNewProbabilidade').classList.remove('hidden');
                    document.getElementById('formEditarJogo').action = `/jogos/${jogoId}`;
                } else {
                    document.getElementById('probabilidade_time_casa_forebet').value = jogo.probabilidade_time_casa_forebet || '';
                    document.getElementById('probabilidade_time_fora_forebet').value = jogo.probabilidade_time_fora_forebet || '';
                    document.getElementById('probabilidade_empate_forebet').value = jogo.probabilidade_empate_forebet || '';
                    document.getElementById('probabilidade_mais_gols_forebet').value = jogo.probabilidade_mais_gols_forebet || '';
                    document.getElementById('probabilidade_menos_gols_forebet').value = jogo.probabilidade_menos_gols_forebet || '';
                    document.getElementById('formEditarJogo').action = `/jogos/${jogoId}`;
                    document.getElementById('modalEditarJogo').classList.remove('hidden');
                }
            });
    }

    function enviarFormulario(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        const form = document.getElementById('formAddJogo');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            if (response.ok) {
                fecharModalNewProbabilidade(); 
            } else {
                
            }
        })
        .catch(error => {
            
        });
    }


    function fecharModal() {
        document.getElementById('modalEditarJogo').classList.add('hidden');
    }
    function fecharModalNewProbabilidade() {
        document.getElementById('modalNewProbabilidade').classList.add('hidden');
    }
</script>

<script>
    const botoesEditar = document.querySelectorAll('.editar-jogo');
    botoesEditar.forEach(botao => {
        botao.addEventListener('click', function() {
            const jogoId = this.getAttribute('data-jogo-id');
            abrirModal(jogoId);
        });
    });
</script>
<script>
    const busca = document.getElementById('busca');
    busca.addEventListener('input', function() {
        const valorBusca = this.value;
        fetch(`/jogos/busca/${valorBusca}`)
            .then(response => response.text())
            .then(data => {
                 document.getElementById('listaJogos').innerHTML = data;
            });
    });
</script>
</html>