<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlPartidasDiretas extends Model
{
    protected $table = 'url_partidas_diretas';

    protected $fillable = [
        'nome',
        'url',
    ];
}
