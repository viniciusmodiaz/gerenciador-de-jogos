<?php
 
namespace App\Http\Controllers;

use Crawly;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

 
class GetJogosController extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function show()
    {
        $url = 'https://www.betano.bet.br/sport/futebol/jogos-de-hoje/';

        $crawler = Crawly::crawl($url);
        dd('chegou aqui!');

        
        $jogos = $crawler->filter('.tw-flex tw-flex-col tw-justify-start tw-items-center tw-py-nn tw-min-w-0 tw-w-full')->each(function ($node) {
            // Adapte os seletores CSS para extrair os dados desejados
            // $time1 = $node->filter('.seu-seletor-css-time1')->text();
            // $time2 = $node->filter('.seu-seletor-css-time2')->text();
            // $horario = $node->filter('.seu-seletor-css-horario')->text();

            dd($node);
            // return [
            //     'time1' => $time1,
            //     'time2' => $time2,
            //     'horario' => $horario,
            // ];
        });

        return ;
    }
}