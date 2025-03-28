<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\UrlPartidasDiretas;

class UrlParidasDiretasRepository 
{
    public function __construct(
        private UrlPartidasDiretas $urlPartidasDiretas
    )
    {
        $this->urlPartidasDiretas = $urlPartidasDiretas;
    }

    public function allUrls()
    {
        $data = $this->urlPartidasDiretas->whereNotNull('url')->where('sinc', 0)->get();

        return $data;
    }

    public function changeSinc($id)
    {
        return  $this->urlPartidasDiretas::where('id', $id)->update([
            'sinc' => true,
        ]);
    }
}