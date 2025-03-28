<?php
 
namespace App\Http\Controllers;

use App\Repositories\PartidaRepository;
use App\Repositories\PartidaPrevisaoRepository;
use Illuminate\Http\Request;

class PartidaController extends Controller
{
    protected $partidaRepository;
  
    public function __construct(
        PartidaRepository $partidaRepository,
        PartidaPrevisaoRepository $partidaPrevisaoRepository
    )
    {
        $this->partidaRepository = $partidaRepository;
        $this->partidaPrevisaoRepository = $partidaPrevisaoRepository;
    }

    public function get($date)
    {
        $jogos = $this->partidaRepository->whereDay(['data_do_jogo' => $date]);

        return view('partidas.index', compact('jogos'));
    }

    public function buscarJogos($param)
    {
        // $busca = $request->input('busca');

        $jogos = $this->partidaRepository->whereNameTimes($param);


        return view('partidas.lista', compact('jogos'));
    }

    public function getPrevisao($id)
    {
        $jogo = $this->partidaPrevisaoRepository->findPartidaId($id);

        if ($jogo) {
            return response()->json([
                'id' => $jogo->id,
            ]);
        } else {
            return response()->json(null); // Retorna null se o jogo não for encontrado
        }
    }
}