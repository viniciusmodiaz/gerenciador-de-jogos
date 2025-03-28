<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Panther\Client;
use App\Repositories\TimeRepository;
use App\Repositories\PartidaRepository;
use App\Repositories\CompeticaoRepository;
use Carbon\Carbon;

class ScrapeData extends Command
{
    protected $signature = 'scrape:data';
    protected $description = 'Scrape data from a website';

    public function handle(TimeRepository $timeRepository, PartidaRepository $partidaRepository, CompeticaoRepository $competicaoRepository)
    {
        $client = Client::createChromeClient();
        $crawler = $client->request('GET', 'https://www.sofascore.com/pt/futebol/2025-03-24');
        $datadojogo = date('Y-m-d', strtotime('+1 day'));

        try {

            $buttonClass = "button.button--variant_clear.button--size_secondary.button--colorPalette_primary.button--negative_false.tt_none"; 
            $buttons = $crawler->filter($buttonClass);

            $buttons->each(function ($button) use ($client) {

                $client->executeScript("arguments[0].scrollIntoView();", [$button->getElement(0)]);
                sleep(1);

                // Clique forçado usando JavaScript
                $client->executeScript("arguments[0].click();", [$button->getElement(0)]);
                sleep(1);
            });

            $client->waitFor('.Text.ezSveL');
            // $client->waitFor('.Text.kcRyBI');
            // $client->waitFor('.Text.kkVniA');

            $elements = $crawler->filter('.Text.ezSveL');
            // $elements_horario = $client->waitFor('.Text.kcRyBI');
            // $elements_horario = $crawler->filter('.Text.kkVniA');

            $partidaTemp = []; 
            $count = $elements->count();


            for ($i = 0; $i < $count; $i++) {
                $element = $elements->getElement($i);
                $nome = $element->getText();
            
                $partidaTemp[] = $nome;
            
                if (($i + 1) % 2 === 0) { 

                    $time_de_casa = $timeRepository->criar(['nome' => $partidaTemp[0]]);
                    $time_de_fora = $timeRepository->criar(['nome' => $partidaTemp[1]]);

                    $partidaRepository->criar([ 
                                                'casa_time_id' => $time_de_casa->id,
                                                'fora_time_id' => $time_de_fora->id, 
                                                'data_do_jogo' => $datadojogo
                                            ]);
                    $partidaTemp = [];
                }
            }


        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
        }

        $client->quit();
    }
}