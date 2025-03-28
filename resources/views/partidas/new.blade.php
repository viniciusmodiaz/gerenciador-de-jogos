<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Lista de Jogos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-4">

    <div class="flex space-x-4">
        @foreach ($jogos as $jogo)
            <div class="bg-white rounded-lg shadow p-4 w-80">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/30" alt="Tuple Logo" class="w-8 h-8 mr-2">
                        <span class="font-semibold">{{ $jogo->timeCasa->nome }} vs {{ $jogo->timeFora->nome }}</span>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">...</button>
                </div>
                <p class="text-sm text-gray-500 mb-2">Lost invoice</p>
                <p class="text-sm text-gray-500 mb-4">{{ $jogo->data_do_jogo }}</p>
                <p class="text-sm">Amount <span class="font-semibold">$2,000.00</span> <span class="text-red-500">Overdue</span></p>
            </div>
        @endforeach
    </div>

</body>
</html>