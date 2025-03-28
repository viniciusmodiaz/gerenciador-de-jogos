<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Partida;
use App\Repositories\PartidaRepository;
use App\Repositories\CompeticaoRepository;
use App\Repositories\TimeRepository;

class FetchGeminiPoisson extends Command
{
    protected $signature = 'fetch:gemini_poisson';
    protected $description = 'Regressão de Poisson';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(PartidaRepository $partidaRepository)
    {
        $apiKey = 'AIzaSyDQ69_bkZGXmQE2Gv7lEO3HghvfoEfEvMk';
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;

        $partidas = $partidaRepository->getJogosGemini();

        foreach($partidas as $partida){

            $jogosTimeCasa = $partidaRepository->whereJogos(['casa_time_id' => $partida->timeCasa->id], ['fora_time_id' => $partida->timeCasa->id]);

            $jogosTimeFora = $partidaRepository->whereJogos(['casa_time_id' => $partida->timeFora->id], ['fora_time_id' => $partida->timeFora->id]);

            $jogosDiretos = $partidaRepository->whereJogosDiretos($partida->timeCasa->id, $partida->timeFora->id);

            $numeroJogosCasa  = $jogosTimeCasa->count();
            $numeroJogosFora  = $jogosTimeFora->count();

            $stringCalculo = "Calcule a probabilidades de 'mais de 0,5 gols, 1,5 gols, 2,5 gols, 3,5 gols' ocorrer em um jogo de futebol entre {$partida->timeCasa->nome} e {$partida->timeFora->nome} usando o modelo de Regressão de Poisson.

            Dados:

            O Primeiro Time aparace no vs sempre vai ser o time da casa
            Histórico de Jogos do {$partida->timeCasa->nome} (últimos {$numeroJogosCasa} jogos):";

            foreach ($jogosTimeCasa as $indice => $jogo) {
                $stringCalculo .= "\n- Jogo:" . ($jogo->timeCasa->nome) ."vs". ($jogo->timeFora->nome).": Gols do {$jogo->timeCasa->nome} = {$jogo->gols_casa}, Gols Sofridos = {$jogo->gols_fora}";
            }

            $stringCalculo .= "\n\nHistórico de Jogos do {$partida->timeFora->nome} (últimos {$numeroJogosFora} jogos):";

            foreach ($jogosTimeFora as $indice => $jogo) {
                $stringCalculo .= "\n- Jogo:" . ($jogo->timeCasa->nome) ."vs". ($jogo->timeFora->nome).": Gols do {$jogo->timeCasa->nome} = {$jogo->gols_casa}, Gols Sofridos = {$jogo->gols_fora}";
            }

            $stringCalculo .= "\n\n Histórico de confronto direito dos dois times: ";

            foreach ($jogosDiretos as $indice => $jogo) {
                $stringCalculo .= "\n- Jogo:" . ($jogo->timeCasa->nome) ."vs". ($jogo->timeFora->nome).": Gols do {$jogo->timeCasa->nome} = {$jogo->gols_casa}, Gols Sofridos = {$jogo->gols_fora}";
            }

            $stringCalculo .= "\n\n Classficação, número de jogos, e: ";
            
            $stringCalculo .= "\n\nInstruções:

            1. Calcule a média de gols marcados e sofridos por cada time com base nos dados fornecidos.
            2. Utilize a Regressão de Poisson para modelar a probabilidade de cada time marcar um determinado número de gols na partida.
            3. Combine as probabilidades dos dois times para calcular a probabilidade total de 'mais de 1,5 gols' ocorrer na partida.
            4. Forneça a probabilidade final em porcentagem (%).";
            

            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $stringCalculo,
                            ],
                        ],
                    ],
                ],
            ]);
            $data = $response->json();

            $partida->probabilidade = $data['candidates'][0]['content']['parts'][0]['text'];
            $partida->gemini_poisson = 1;
            $partida->save();

            if ($response->successful()) {
                $this->info('Probabilidade salva com sucesso!');
            } else {
                $this->error('Erro ao buscar dados da API.');
            }

        }

    }

    private function getMarcadoresGols($event)
    {
        $marcadores = [];

        return implode(', ', $marcadores);
    }

    private function getVencedor($event, $time_de_casa, $time_de_fora)
    {
        if (!isset($event['winnerCode'])) {
            return 'Jogo adiado!';
        } elseif ($event['winnerCode'] == 1) {
            return $time_de_casa;
        } elseif ($event['winnerCode'] == 2) {
            return $time_de_fora;
        } elseif ($event['winnerCode'] == 3) {
            return 'Empate';
        } else {
            return null;
        }
    }
}