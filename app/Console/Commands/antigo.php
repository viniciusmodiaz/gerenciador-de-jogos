<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Panther\Client;

class Teste extends Command
{
    protected $signature = 'scrape:testedasdsa';
    protected $description = 'Scrape data from a website';

    public function handle()
    {
        $client = Client::createChromeClient(); // ou Client::createFirefoxClient()
        $crawler = $client->request('GET', 'https://pt.wix.com/explore/websites');

        // Extrair dados usando seletores CSS ou XPath
        $title = $crawler->filter('h1')->text();
        $links = $crawler->filter('a')->each(function ($node) {
            return $node->attr('href');
        });

        // Exibir os dados extraídos
        $this->info("Título: " . $title);
        $this->info("Links: " . implode(', ', $links));

        $client->quit(); // Fechar o navegador
    }
}