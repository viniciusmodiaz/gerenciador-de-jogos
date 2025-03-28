
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PartidaRepository;

class JogoController extends Controller
{
    
    public function simularGols(Request $request)
    {
        $lambda = 1.5; // Número médio de gols por jogo
        $numGols = $this->gerarNumeroPoisson($lambda);

        return response()->json(['gols' => $numGols]);
    }

    private function gerarNumeroPoisson($lambda)
    {
        $l = exp(-$lambda);
        $k = 0;
        $p = 1;

        do {
            $k++;
            $p *= rand(0, PHP_INT_MAX) / PHP_INT_MAX;
        } while ($p > $l);

        return $k - 1;
    }

    public function calcularMediaGols(int $timeId)
    {
        $time = Time::find($timeId);

        $golsMarcados = 0;
        $jogos = 0;

        foreach ($time->jogosCasa as $jogo) {
            $golsMarcados += $jogo->gols_casa;
            $jogos++;
        }

        foreach ($time->jogosVisitante as $jogo) {
            $golsMarcados += $jogo->gols_visitante;
            $jogos++;
        }

        if ($jogos > 0) {
            $mediaGols = $golsMarcados / $jogos;
            return $mediaGols;
        } else {
            return 0;
        }
    }
}