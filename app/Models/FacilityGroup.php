<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class FacilityGroup extends Model
{
    use LadaCacheTrait;

    protected $fillable = [
        'name'
    ];

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}
