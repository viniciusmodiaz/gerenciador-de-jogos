<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competicao extends Model
{
    protected $table = 'competicao';
    
    protected $fillable = [
        'nome',
    ];
}
