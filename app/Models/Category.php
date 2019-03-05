<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Category extends Model
{
    use LadaCacheTrait;
    public function tourisms()
    {
        return $this->belongsToMany(Tourism::class);
    }
}
