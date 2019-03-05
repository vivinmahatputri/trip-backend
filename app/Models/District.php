<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class District extends Model
{
    use LadaCacheTrait;

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
