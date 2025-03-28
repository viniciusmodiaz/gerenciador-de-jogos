<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Panther\Client;
use App\Repositories\TimeRepository;
use App\Repositories\PartidaRepository;

class Ol extends Command
{
    protected $signature = 'scrape:tessadas';
    protected $description = 'Scrape data from a website';

    public function handle(TimeRepository $timeRepository, PartidaRepository $partidaRepository)
    {
        $client = Client::createChromeClient(); // ou Client::createFirefoxClient()
        $crawler = $client->request('GET', 'https://www.sofascore.com/football/2025-03-03');
        // $dataAmanha = date('Y-m-d', strtotime('+1 day'));
        $datadojogo = date('Y-m-d');

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

            $elements = $crawler->filter('.Text.ezSveL');

            $partidaTemp = []; 
            $count = $elements->count();


            for ($i = 0; $i < $count; $i++) {
                $element = $elements->getElement($i);
                $nome = $element->getText();
            
                $partidaTemp[] = $nome;
            
                if (($i + 1) % 2 === 0) { 

                    $time_de_casa = $timeRepository->criar(['nome' => $partidaTemp[0]]);
                    $time_de_fora = $timeRepository->criar(['nome' => $partidaTemp[1]]);

                    $partidaRepository->criar([ 'casa_time_id' => $time_de_casa->id,
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