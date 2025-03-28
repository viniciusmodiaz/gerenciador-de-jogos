<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Jogos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Lista de Jogos</h1>

        <ul class="space-y-4">
            @foreach ($jogos as $jogo)
                <li class="bg-white rounded-lg shadow p-4">
                    <p>
                        {{ $jogo->timeCasa->nome }} vs {{ $jogo->timeFora->nome }} -
                        {{ $jogo->data_do_jogo }}
                    </p>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $jogos->links() }}
        </div>
    </div>
</body>
</html>