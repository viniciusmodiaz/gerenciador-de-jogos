<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Panther\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Repositories\TimeRepository;
use App\Repositories\PartidaRepository;
use App\Repositories\CompeticaoRepository;

class ScrapeTime extends Command
{
    protected $signature = 'scrape:time';
    protected $description = 'Scrape dos times';

    public function handle(TimeRepository $timeRepository, PartidaRepository $partidaRepository, CompeticaoRepository $competicaoRepository)
    {
        $times = $timeRepository->allUrls();

        try {
            foreach ($times as $time) {
                $client = Client::createChromeClient();
                $crawler = $client->request('GET', $time->url);

                // Espera por 5 segundos
                sleep(5);

                // Rola para o final da página
                $client->executeScript('window.scrollTo(0, document.body.scrollHeight);');

                // Espera mais 3 segundos após a rolagem
                sleep(3);

                // Espera que o elemento seja carregado
                $client->waitFor('.leagues--static.event--leagues.summary-results');

                $sections = $crawler->filter('.leagues--static.event--leagues.summary-results');
                dd($sections->count());

                $sections->each(function (Crawler $section) use ($partidaRepository, $timeRepository, $competicaoRepository, $client) {
                    $nome_campeonato = $section->filter('.wcl-header_uBhYi.wcl-pinned_WU5N6.wclLeagueHeader.wclLeagueHeader--collapsed.wclLeagueHeader--noCheckBox.wclLeagueHeader--indent')->first()->text();
                    dd($nome_campeonato);
                });

                $client->quit();
            }
        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
            $this->error("Linha: " . $e->getLine());
            $this->error("Arquivo: " . $e->getFile());
        }
    }
}