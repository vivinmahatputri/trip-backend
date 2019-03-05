<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Accessibility extends Model
{
    use LadaCacheTrait;

    protected $fillable = [
        'name'
    ];
}
