<?php

namespace App\Http\Controllers;

use RoachPHP\Roach;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Http\Response;
use Generator; // Adicione esta linha

class BetanoSpider extends BasicSpider
{
    public array $startUrls = [
        'https://www.betano.bet.br/sport/futebol/jogos-de-hoje/', // Substitua pela URL correta
    ];

    public function parse(Response $response): Generator // Altere o tipo de retorno
    {
        // Adapte os seletores CSS/XPath para extrair os dados desejados
        $jogos = $response->filter('.tw-flex tw-flex-col tw-justify-start tw-items-center tw-w-full tw-h-full tw-pt-nm')->each(function ($node) {
            $nome = $node->filter('.tw-truncate tw-text-s tw-font-medium tw-leading-s tw-text-n-13-steel dark:tw-text-white-snow')->text();
            $horario = $node->filter('.tw-flex tw-flex-row tw-justify-between tw-align-center tw-w-full tw-items-center tw-px-nm')->text();
            // ... extraia outros dados relevantes

            return [
                'nome' => $nome,
                'horario' => $horario,
            ];
        });

        foreach ($jogos as $jogo) { // Use um loop foreach para gerar os itens
            yield $jogo;
        }
    }
}

class BetanoController extends Controller
{
    public function obterJogos()
    {
        $resultados = Roach::collectSpider(BetanoSpider::class);
        return response()->json($resultados);
    }
}