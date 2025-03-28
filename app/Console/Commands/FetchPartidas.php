<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Partida;
use App\Repositories\PartidaRepository;
use App\Repositories\CompeticaoRepository;
use App\Repositories\TimeRepository;

class FetchPartidas extends Command
{
    protected $signature = 'fetch:partidas';
    protected $description = 'Busca e salva os dados das partidas da API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(TimeRepository $timeRepository, PartidaRepository $partidaRepository, CompeticaoRepository $competicaoRepository)
    {
        $times = $timeRepository->allUrls();
        foreach ($times as $time) {
            $response = Http::get($time->url);

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data['events'] as $event) {

                    $time_de_casa   = $timeRepository->criar(['nome' => $event['homeTeam']['name']]);
                    $time_de_fora   = $timeRepository->criar(['nome' => $event['awayTeam']['name']]);
                    $competicao     = $competicaoRepository->criar(['nome' => $event['tournament']['name']]);

                    $partidaRepository->criarPartida([ 
                        'casa_time_id' => $time_de_casa->id,
                        'fora_time_id' => $time_de_fora->id, 
                        'data_do_jogo' => date('Y-m-d', $event['startTimestamp']),
                        'resultado' => $this->getVencedor($event, $time_de_casa->id, $time_de_fora->id),
                        'gols_casa' =>  $event['homeScore']['normaltime'] ?? null,
                        'gols_fora' => $event['awayScore']['normaltime'] ?? null,
                        'gol_primeiro_tempo_casa' => $event['homeScore']['period1'] ?? null,
                        'gol_segundo_tempo_casa' => $event['homeScore']['period2'] ?? null,
                        'gol_primeiro_tempo_fora' => $event['awayScore']['period1'] ?? null,
                        'gol_segundo_tempo_fora' => $event['awayScore']['period2'] ?? null,
                        'competicao_id' => $competicao->id
                    ]);
                }

                $this->info('Dados das partidas salvos com sucesso!');
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